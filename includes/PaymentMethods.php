<?php

class PaymentMethods
{
	public static $canInstall='no';

	public static $canUninstall='no';

	public static $installFolderName='';

	public static $uninstallFolderName='';

	public static $error='';

	public static $canAddZone='no';

	public static $renderFolderName='';

	public static $renderPluginPath='';


	public function makeInstall($foldername)
	{
		self::$canInstall='yes';

		self::$canAddZone=='yes';

		self::$installFolderName=$foldername;

		$insertData=array(
			'foldername'=>$foldername,
			'installed'=>1,
			'status'=>0

			);

		self::insert($insertData);		

	}
	public function makeUninstall($foldername)
	{
		self::$canUninstall='yes';

		self::$uninstallFolderName=$foldername;

		Database::query("delete from payment_methods where foldername='$foldername'");		

	}

	public function install($funcName)
	{
		// $foldername=self::$installFolderName;

		if(self::$canInstall=='no')
		{
			return false;
		}

		$data=debug_backtrace();	

		$pluginPath=dirname($data[0]['file']).'/';

		$foldername=basename($pluginPath);	

		$loadData=self::get(array(
			'where'=>"where foldername='$foldername'"
			));

		if(isset($loadData[0]['foldername']))
		{
			return false;
			
		}

		$reFolderName=ucfirst($foldername);

		if(method_exists($reFolderName, $funcName))
		{
			$reFolderName::$funcName();
		}

		// $insertData=array(
		// 	'foldername'=>$foldername,
		// 	'installed'=>1,
		// 	'status'=>0

		// 	);

		// self::insert($insertData);


	}

	// public function uninstall($funcName)
	// {
	// 	$foldername=self::$uninstallFolderName;

	// 	if(self::$canUninstall=='no')
	// 	{
	// 		return false;
	// 	}

	// 	$reFolderName=ucfirst($foldername);

	// 	if(method_exists($reFolderName, $funcName))
	// 	{
	// 		$reFolderName::$funcName();
	// 	}

		
	// }

	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="methodid,title,foldername,method_data,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from payment_methods $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:15;

		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=DBCache::get($queryCMD,$cacheTime);

			if($loadCache!=false)
			{
				return $loadCache;
			}

			// end load			
		}


		$query=Database::query($queryCMD);
		
		if(isset(Database::$error[5]))
		{
			return false;
		}

		$inputData['isHook']=isset($inputData['isHook'])?$inputData['isHook']:'yes';
		
		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				if(isset($row['title']))
				{
					$row['title']=String::decode($row['title']);
				}

				if(isset($row['date_added']))
				$row['date_addedFormat']=Render::dateFormat($row['date_added']);	

											
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}

		// Save dbcache
		DBCache::make(md5($queryCMD),$result);
		// end save


		return $result;
		
	}

	public function getDirs($inputData=array())
	{

		$loadData=self::get();

		$total=count($loadData);

		$dbPlugins=array();

		if(isset($loadData[0]['foldername']))
		for ($i=0; $i < $total; $i++) { 

			$foldername=$loadData[$i]['foldername'];

			$dbPlugins[$foldername]['status']=$loadData[$i]['status'];
			$dbPlugins[$foldername]['installed']=$loadData[$i]['installed'];

		}



		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:10;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$listDir=Dir::listDir(PAYMENTMETHODS_PATH);

		$total=count($listDir);

		$resultData=array();

		for($i=$limitPage;$i<$limitShow;$i++)
		{
			if(!isset($listDir[$i]))
			{
				continue;
			}

			$folderName=$listDir[$i];

			$isSetting=0;
			
			$path=PAYMENTMETHODS_PATH.$folderName.'/';
			$url=PAYMENTMETHODS_PATH.$folderName.'/';

			$pluginInfo=file($path.'info.txt');

			if(file_exists($path.'setting.php'))
			{
				$isSetting=1;
			}

			$resultData[$i]['title']=$pluginInfo[0];
			$resultData[$i]['author']=$pluginInfo[1];
			$resultData[$i]['version']=$pluginInfo[2];
			$resultData[$i]['summary']=isset($pluginInfo[3])?$pluginInfo[3]:'';
			$resultData[$i]['url']=isset($pluginInfo[4])?$pluginInfo[4]:'';
			$resultData[$i]['foldername']=$folderName;
			$resultData[$i]['status']=isset($dbPlugins[$folderName])?$dbPlugins[$folderName]['status']:'0';
			$resultData[$i]['install']=isset($dbPlugins[$folderName])?$dbPlugins[$folderName]['installed']:'0';
			$resultData[$i]['setting']=$isSetting;
					

		}

		return $resultData;
		
	}

	public function saveCache()
	{
		$loadData=self::get();

		if(isset($loadData[0]['foldername']))
		{
			Cache::saveKey('listPaymentMethods',serialize($loadData));
		}
	}

	public function loadCache()
	{
		if(!$loadData=Cache::loadKey('listPaymentMethods',-1))
		{
			return false;
		}

		$loadData=unserialize($loadData);

		return $loadData;
	}

	public function import()
	{
		$resultData=File::uploadMultiple('theFile','uploads/tmp/');

		$total=count($resultData);

		for($i=0;$i<$total;$i++)
		{
			$targetPath='';

			$theFile=$resultData[$i];

			$sourcePath=ROOT_PATH.$theFile;

			$shortPath='contents/paymentmethods/'.basename($theFile);

			$targetPath.=$shortPath;

			File::move($sourcePath,$targetPath);

			$sourcePath=dirname($sourcePath);

			rmdir($sourcePath);

			File::unzipModule($targetPath,'yes');
		}		
	}
	public function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		if(isset($inputData[0]['title']))
		{
		    foreach ($inputData as $theRow) {

				$theRow['date_added']=date('Y-m-d h:i:s');

				if(isset($theRow['title']))
				$theRow['title']=String::encode($theRow['title']);

				$keyNames=array_keys($theRow);

				$insertKeys=implode(',', $keyNames);

				$keyValues=array_values($theRow);

				$insertValues="'".implode("','", $keyValues)."'";

				$addMultiAgrs.="($insertValues), ";

		    }

		    $addMultiAgrs=substr($addMultiAgrs, 0,strlen($addMultiAgrs)-2);
		}
		else
		{
			$inputData['date_added']=date('Y-m-d h:i:s');

			if(isset($inputData['title']))
			$inputData['title']=String::encode($inputData['title']);

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into payment_methods($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			return $id;	
		}

		return false;
	
	}

	public function remove($post=array(),$whereQuery='',$addWhere='')
	{


		if(is_numeric($post))
		{
			$id=$post;

			unset($post);

			$post=array($id);
		}

		$total=count($post);

		$listID="'".implode("','",$post)."'";

		$whereQuery=isset($whereQuery[5])?$whereQuery:"methodid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from payment_methods where $whereQuery $addWhere";

		Database::query($command);	

		return true;
	}

	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['title']))
		{
			$post['title']=String::encode($post['title']);
		}		

		if(is_numeric($listID))
		{
			$catid=$listID;

			unset($listID);

			$listID=array($catid);
		}

		$listIDs="'".implode("','",$listID)."'";		
				
		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"methodid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update payment_methods set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>