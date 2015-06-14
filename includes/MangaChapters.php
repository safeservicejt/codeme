<?php

class MangaChapters
{

	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="chapterid,title,content_type,is_featured,featured_date,friendly_url,content,number,views,date_added,mangaid,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by chapterid desc';

		$result=array();
		
		$command="select $selectFields from chapter_list $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		// Load dbcache

		$loadCache=DBCache::get($queryCMD);

		if($loadCache!=false)
		{
			return $loadCache;
		}

		// end load

		$query=Database::query($queryCMD);

		if(isset(Database::$error[5]))
		{
			return false;
		}		
		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				if(isset($row['title']))
				{
					$row['title']=String::decode($row['title']);
				}
				if(isset($row['date_added']))
				{
					$row['date_added']=Render::dateFormat($row['date_added']);
				}				

				if(isset($row['content']) && isset($row['content_type']) && $row['content_type']!='url')
				{
					$li='';

					$liIMG='';

					$parse=explode("\r\n", $row['content']);

					$totalIMG=count($parse);

					for ($j=0; $j < $totalIMG; $j++) { 
						// $li.=ROOT_URL.$parse[$j]."\r\n";

						$liIMG.='<img data-src="'.ROOT_URL.$parse[$j].'" class="js-auto-responsive" />'."\r\n";
					}

					// $row['content']=$li;

					$row['contentFormat']=$liIMG;				
				}

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

	public function insert($inputData=array())
	{
		if(isset($inputData['title']))
		$inputData['friendly_url']=String::encode(Url::makeFriendly($inputData['title']));

		$inputData['title']=String::encode($inputData['title']);

		$inputData['date_added']=date('Y-m-d h:i:s');

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into chapter_list($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	
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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"chapterid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		// die("update chapter_list set $setUpdates where $whereQuery $addWhere");

		Database::query("update chapter_list set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"chapterid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";
			
		$command="delete from chapter_list where $whereQuery $addWhere";


		$getData=self::get(array(
			'where'=>"where $whereQuery"
			));

		$total=count($getData);

		if(isset($getData[0]['chapterid']))
		for ($i=0; $i < $total; $i++) { 

			if($getData[$i]['content_type']=='url')
			{
				continue;
			}

			$parse=explode("\r\n", $getData[$i]['content']);
			
			$totalIMG=count($parse);

			for ($j=0; $j < $totalIMG; $j++) { 

				if(preg_match('/.*?\.\w+/i', $parse[$j]))
				{
					$image=ROOT_PATH.$parse[$j];

					if(file_exists($image))
					{
						unlink($image);

						$dirname=dirname($image);

						rmdir($dirname);
					}					
				}

			}

		}

		Database::query($command);		

		return true;
	}

}
?>