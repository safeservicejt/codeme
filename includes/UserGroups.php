<?php

class UserGroups
{
	public static $groupData=array();

	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="groupid,group_title,groupdata";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by groupid desc';

		$result=array();
		
		$command="select $selectFields from usergroups $whereQuery";

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

				if(isset($row['date_added']))
				$row['date_addedFormat']=Render::dateFormat($row['date_added']);	

				if(isset($row['groupdata']))
				$row['groupdata']=self::arrayToLine($row['groupdata']);
											
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

	public function loadGroup($groupid)
	{
		if(!$loadData=Cache::loadKey('userGroup1_'.$groupid,-1))
		{
			$loadData=self::get(array(
				'where'=>"where groupid='$groupid'"
				));

			if(!isset($loadData[0]['groupid']))
			{
				return false;
			}

			$loadData[0]['groupdata']=unserialize(self::lineToArray($loadData[0]['groupdata']));

			self::$groupData=$loadData[0];
		}
	}



	public function removePermission($groupid,$inputData=array())
	{
		$loadData=self::get(array(
			'where'=>"where groupid='$groupid'"
			));

		if(!isset($loadData[0]['groupid']))
		{
			return false;
		}

		$total=count($inputData);

		if($total==0)
		{
			return false;
		}

		$groupdata=unserialize(self::lineToArray($loadData[0]['groupdata']));

		// $listKeys=array_keys($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$inputData[$i];

			// $groupdata[$keyName]=$inputData[$keyName];

			if(isset($groupdata[$keyName]))
			{
				unset($groupdata[$keyName]);
			}
		}

		$groupdata=serialize(self::arrayToLine($groupdata));

		self::update($groupid,$groupdata);
	}

	public function addPermission($groupid,$inputData=array())
	{
		$loadData=self::get(array(
			'where'=>"where groupid='$groupid'"
			));

		if(!isset($loadData[0]['groupid']))
		{
			return false;
		}

		$total=count($inputData);

		if($total==0)
		{
			return false;
		}

		$groupdata=unserialize(self::lineToArray($loadData[0]['groupdata']));

		$listKeys=array_keys($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$listKeys[$i];

			$groupdata[$keyName]=$inputData[$keyName];
		}

		$groupdata=serialize(self::arrayToLine($groupdata));

		self::update($groupid,$groupdata);
	}
	
	public function getPermission($groupid,$keyName)
	{
		$loadData=array();

		if(!isset(self::$groupData['groupdata']))
		{
			if(!$loadData=Cache::loadKey('userGroup1_'.$groupid,-1))
			{
				$loadData=self::get(array(
					'where'=>"where groupid='$groupid'"
					));

				if(!isset($loadData[0]['groupid']))
				{
					return false;
				}

				$loadData[0]['groupdata']=unserialize(self::lineToArray($loadData[0]['groupdata']));

				$loadData=$loadData[0];
			}
			else
			{
				$loadData=unserialize($loadData);

				$loadData['groupdata']=unserialize($loadData['groupdata']);
			}

			self::$groupData=$loadData;	

			$groupData=$loadData['groupdata'];		
		}
		else
		{
			$groupData=self::$groupData['groupdata'];
		}

		$value=isset($groupData[$keyName])?$groupData[$keyName]:false;

		return $value;

	}

	public function arrayToLine($data)
	{
		if(!isset($data[5]))
		{
			return '';
		}

		$data=unserialize($data);

		$total=count($data);

		$listKeys=array_keys($data);

		$li='';

		for ($i=0; $i < $total; $i++) { 
			$theKey=$listKeys[$i];

			$theValue=$data[$theKey];

			$li.=$theKey.'|'.$theValue."\r\n";
		}

		return $li;

	}

	public function lineToArray($data)
	{
		$resultData=array();

		$parse=explode("\r\n", $data);

		if(!isset($parse[0][1]))
		{
			return '';
		}


		$total=count($parse);

		for ($i=0; $i < $total; $i++) { 

			if(!isset($parse[$i][5]))
			{
				continue;
			}

			$theLine=explode('|', $parse[$i]);

			$theKey=trim($theLine[0]);

			$theValue=trim($theLine[1]);

			$resultData[$theKey]=$theValue;
		}

		$resultData=serialize($resultData);



		return $resultData;
	}

	public function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		//groupdata: can_edit_post|yes/no
		//				can_loggedin_to_admincp|yes/no
		//				can_view_front_end|yes/no



		$addMultiAgrs='';

		if(isset($inputData[0]['group_title']))
		{
		    foreach ($inputData as $theRow) {

		    	$theRow['groupdata']=self::lineToArray($theRow['groupdata']);

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
			$inputData['groupdata']=self::lineToArray($inputData['groupdata']);

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into usergroups($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			$inputData['groupdata']=self::lineToArray($inputData['groupdata']);

			Cache::saveKey('userGroup_'.$id,serialize($inputData));

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"groupid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from usergroups where $whereQuery $addWhere";

		Database::query($command);	

		for ($i=0; $i < $total; $i++) { 

			$id=$post[$i];

			Cache::removeKey('userGroup_'.$id);
		}

		return true;
	}

	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{

		if(isset($post['groupdata']))
		{
			$post['groupdata']=self::lineToArray($post['groupdata']);
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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"groupid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update usergroups set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			$loadData=self::get(array(
				'where'=>"where groupid IN ($listIDs)"
				));

			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 

				$loadData[$i]['groupdata']=self::lineToArray($loadData[$i]['groupdata']);
				Cache::saveKey('userGroup_'.$loadData[$i]['groupid'],serialize($loadData[$i]));
			}

			return true;
		}

		return false;
	}


}
?>