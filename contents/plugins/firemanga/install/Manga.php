<?php

class Manga
{
	private static $postData=array();

	private static $mangaid=0;

	private static $isGet='no';

	private static $totalPost=0;
	
	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="mangaid,title,friendly_url,views,is_featured,featured_date,image,summary,rating,authorid,keywords,date_added,compeleted,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();		
		$command="select $selectFields from manga_list $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$inputData['isHook']=isset($inputData['isHook'])?$inputData['isHook']:'yes';

		// self::category();

		$catid=0;

		$cattitle='';


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

		$total=Database::num_rows($query);

		if((int)$total > 0)
		{
			while($row=Database::fetch_assoc($query))
			{

				if(isset($row['title']))
				{
					$row['title']=String::decode($row['title']);
				}
				
				if(isset($row['keywords']))
				{
					$row['keywords']=String::decode($row['keywords']);
				}

				if(isset($row['summary']))
				{
					$row['summary']=String::decode($row['summary']);
				}

				if(isset($row['image']))
				{
					$row['imageUrl']=Render::thumbnail($row['image']);
				}

				$cattitle='';	
							
				$row['date_added']=isset($row['date_added'])?Render::dateFormat($row['date_added']):'';

				if(isset($row['friendly_url']))
				{
					$row['url']=Url::post($row);
				}

				if(isset($inputData['isHook']) && $inputData['isHook']=='yes')
				{	
					if(isset($row['summary']))
					$row['summary']=Shortcode::load($row['summary']);
				}

				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}


		// Save dbcache
		// print_r($result);
		// die();
		DBCache::make(md5($queryCMD),$result);
		// end save

		return $result;
		
	}

	public function url($row=array(0))
	{
		if(!isset($row['mangaid']) || !isset($row['friendly_url']))
		{
			return '';
		}

		$resultData=ROOT_URL.'manga/'.$row['mangaid'].'-'.$row['friendly_url'].'.html';

		return $resultData;
	}


	public function tags($id)
	{
		$loadData=MangaTags::get(array(
			'where'=>"where mangaid='$id'"
			));

		return $loadData;
	}


	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['title']))
		{
			$post['title']=String::encode($post['title']);
		}
		
		if(isset($post['keywords']))
		{
			$post['keywords']=String::encode($post['keywords']);
		}

		if(isset($post['content']))
		{
			$post['content']=Shortcode::toBBcode($post['content']);
			
			$post['content']=strip_tags($post['content']);
			
			$post['content']=String::encode($post['content']);
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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"mangaid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update manga_list set $setUpdates where $whereQuery $addWhere");

		if(isset(Database::$error[5]))
		{
			return false;
		}

		return true;
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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"mangaid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="select image from manga_list where mangaid in ($listID)";

		$query=Database::query($command);

		while($row=Database::fetch_assoc($query))
		{
			$thumbnail=ROOT_PATH.$row['image'];

			if(!is_dir($thumbnail) && file_exists($thumbnail))
			{
				unlink($thumbnail);

				$thumbnail=dirname($thumbnail);

				rmdir($thumbnail);
			}
		}		

		$command="delete from manga_list where $whereQuery $addWhere";

		Database::query($command);	

		MangaTags::remove($post);

		MangaCategories::remove($post);

		MangaChapters::remove($post,"mangaid IN ($listID)");

		return true;
	}

	public function insert($inputData=array())
	{
		$inputData['friendly_url']=String::encode(Url::makeFriendly($inputData['title']));

		if(isset($inputData['title']))
		{
			$inputData['title']=String::encode($inputData['title']);
		}
		if(isset($inputData['keywords']))
		{
			$inputData['keywords']=String::encode($inputData['keywords']);
		}

		if(isset($inputData['summary']))
		{
			$inputData['summary']=Shortcode::toBBcode($inputData['summary']);

			$inputData['summary']=strip_tags($inputData['summary']);

			$inputData['summary']=String::encode($inputData['summary']);
		}

		if(!isset($inputData['authorid']))
		{
			$loadCat=MangaAuthors::get(array(
				'limitShow'=>1,
				'orderby'=>'order by date_added'
				));

			if(isset($loadCat[0]['authorid']))
			{
				$inputData['authorid']=$loadCat[0]['authorid'];
			}
		}
				
		$inputData['date_added']=date('Y-m-d h:i:s');

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into manga_list($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			return $id;	
		}

		return false;
	}

	public function insertTags($id,$tagStr='')
	{
		if(!isset($tagStr[1]))
		{
			return false;
		}

		$loadData=array();

		if(preg_match('/\,/i', $tagStr))
		{
			$listTags=explode(',', $tagStr);

			$total=count($listTags);	

			for($i=0;$i<$total;$i++)
			{
				$loadData[$i]['title']=trim($listTags[$i]);

				$loadData[$i]['mangaid']=$id;
			}		
		}
		else
		{
			$loadData[0]['title']=trim($tagStr);
			$loadData[0]['mangaid']=$id;			
		}

		$totalTag=count($loadData);

		$theTag='';

		MangaTags::remove(array($id));

		for($i=0;$i<$totalTag;$i++)
		{
			$theTag=$loadData[$i]['title'];

			if(preg_match('/\'|\"|\//', $theTag))
			{
				continue;
			}

			MangaTags::insert($loadData[$i]);
		}

	}	



}

?>