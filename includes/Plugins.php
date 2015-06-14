<?php

class Plugins
{

	/*
	Plugin:
	- foldername
	- func
	- status
	- zonename
	- layoutname
	- layoutposition
	- content
	*/

	public static $listCaches=array('loaded'=>'no');

	public static $listShortCodes=array('loaded'=>'no');

	public static $canInstall='no';

	public static $canUninstall='no';

	public static $installFolderName='';

	public static $uninstallFolderName='';

	public static $error='';

	public static $canAddZone='no';

	public static $renderFolderName='';

	public static $renderPluginPath='';

	public static $thisPluginPath='';

	public static $listZones=array(
		'before_system_start'=>array(
			'return'=>'no',
			'input'=>'no',
			'zone'=>'global'
			),

		'after_database_connected'=>array(
			'return'=>'no',
			'input'=>'no',
			'zone'=>'global'
			),

		'after_system_start'=>array(
			'return'=>'no',
			'input'=>'no',
			'zone'=>'global'
			),

		'site_header'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'frontend'
			),
		'site_footer'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'frontend'
			),
		'admincp_header'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'admincp'
			),
		'admincp_footer'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'admincp'
			),
		'usercp_header'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'admincp'
			),
		'usercp_footer'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'usercp'
			),
		'after_insert_user'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'global'
			),
		'after_insert_comment'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'global'
			),
		'after_insert_post'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'global'
			),
		'after_insert_page'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'global'
			),
		'after_insert_review'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'global'
			),
		'after_insert_product'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'global'
			),
		'after_insert_category'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'global'
			),
		'after_insert_order'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'global'
			),

		'after_user_loggedin'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'global'
			),

		'shortcode'=>array(
			'return'=>'yes',
			'input'=>'yes',
			'zone'=>'global'
			),

		'content_left'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'frontend'
			),
		'content_right'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'frontend'
			),
		'content_top'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'frontend'
			),
		'content_bottom'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'frontend'
			),

		'admincp_setting_menu'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'admincp'
			),
		'admincp_theme_menu'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'admincp'
			),
		'admincp_plugin_menu'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'admincp'
			),
		'admincp_navbar'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'admincp'
			),
		'admincp_menu'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'admincp'
			),

		'usercp_navbar'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'usercp'
			),
		'usercp_menu'=>array(
			'return'=>'yes',
			'input'=>'no',
			'zone'=>'usercp'
			)
		);


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

		$listDir=Dir::listDir(PLUGINS_PATH);

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
			
			$path=PLUGINS_PATH.$folderName.'/';
			$url=PLUGINS_URL.$folderName.'/';

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

	public function writeError($str)
	{
		self::$error=$str;
	}

	public function getError($str)
	{
		return self::$error;
	}

	public function add($zoneName,$funcName)
	{
		$inputData=array();

		$data=debug_backtrace();	

		$pluginPath=dirname($data[0]['file']).'/';

		$foldername=basename($pluginPath);
			
		if(!isset($foldername[2]))
		{
			// throw new Exception("Plugin folder name must have to large than 2 character.");

			self::writeError("Plugin folder name must have to large than 2 character.");

			return false;
		}

		// $inputData['status']=1;

		self::$canAddZone='yes';

		$inputData['foldername']=$foldername;

		$inputData['zonename']=$zoneName;

		$inputData['func']=$funcName;

		if(!PluginsMeta::insert($inputData))
		{
			self::writeError("Error. ".Database::$error);

			return false;			
		}

	
		PluginsZone::addPlugin($inputData['zonename'],$inputData);
	}



	public function load($zoneName='',$inputData=array())
	{

		if(!isset(self::$listCaches[$zoneName]))
		{
			return $inputData;
		}

		$resultString='';

		$li='';

		$resultData=array();

		$stringData='';

		$arrayData=array();

		$intData=0;

		$objectData='';

		$resultArray=array();

		$zoneList=self::$listCaches[$zoneName];

		$total=count($zoneList);

		for ($i=0; $i < $total; $i++) { 

			$theZone=$zoneList[$i];

			$zonePath=PLUGINS_PATH.$theZone['foldername'].'/';

			self::$renderFolderName=$theZone['foldername'];

			self::$renderPluginPath=$zonePath;

			if(!is_dir($zonePath))
			{
				continue;
			}

			$zonePath.='index.php';

			if(!file_exists($zonePath))
			{
				continue;
			}

			$funcName=$theZone['func'];



			if(!function_exists($funcName))
			{
				include($zonePath);
			}
			
			$li=$funcName($inputData);

			if(is_array($li))
			{
				$inputData=$li;
			}
		}


		return $li;

	}

	public function makeInstall($foldername)
	{
		self::$canInstall='yes';

		self::$canAddZone=='yes';

		self::$installFolderName=$foldername;
	}
	public function makeUninstall($foldername)
	{
		self::$canUninstall='yes';

		self::$uninstallFolderName=$foldername;

		Database::query("delete from plugins where foldername='$foldername'");		

		Database::query("delete from plugins_meta where foldername='$foldername'");		

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

		if(function_exists($funcName))
		{
			$funcName();
		}

		$insertData=array(
			'foldername'=>$foldername,
			'installed'=>1,
			'status'=>0

			);

		self::insert($insertData);


	}

	public function uninstall($funcName)
	{
		$foldername=self::$uninstallFolderName;

		if(self::$canUninstall=='no')
		{
			return false;
		}

		if(function_exists($funcName))
		{
			$funcName();
		}

		
	}


	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="foldername,type,status,installed,date_added";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from plugins $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:15;

		$query=Database::query($queryCMD);
		
		if(isset(Database::$error[5]))
		{
			return false;
		}

		
		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}


		return $result;
		
	}

	public function insert($inputData=array())
	{
		// End addons
		$totalArgs=count($inputData);

		$addMultiAgrs='';

		if(isset($inputData[0]['foldername']))
		{
		    foreach ($inputData as $theRow) {

				$theRow['date_added']=date('Y-m-d h:i:s');

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

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into plugins($insertKeys) values".$addMultiAgrs);

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"foldername in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from plugins where $whereQuery $addWhere";

		$command="delete from plugins_meta where $whereQuery $addWhere";

		Database::query($command);	

		return true;
	}


	public function api($inputData)
	{
		/*
		Route->Function
		$inputData=array(
			'route_name'=>'function_to_call'
		);

		*/

		$data=debug_backtrace();
		/*

	    [0] => Array
	        (
	            [file] => D:\wamp\htdocs\project\2015\noblessecmsv2\routes.php
	            [line] => 8
	            [function] => api
	            [class] => Plugins
	            [type] => ::
	            [args] => Array
	                (
	                )

	        )



		*/		

		$pluginPath=dirname($data[0]['file']).'/';

		$foldername=basename($pluginPath);


		
	}


}

?>