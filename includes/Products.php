<?php

class Products
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

		$field="productid,catid,sku,upc,model,price,quantity,date_added,title,content,attributes,friendly_url,image,points,userid,is_featured,date_featured,is_shipping,manufacturerid,minimum,sort_order,viewed,keywords,date_discount,date_enddiscount,date_available,price_discount,options_command,quantity_discount,rating,status";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by productid desc';

		$result=array();
		
		$command="select $selectFields from products $whereQuery";

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
				if(isset($row['content']))
				{
					$row['content']=String::decode($row['content']);
				}
				if(isset($row['image']))
				{
					$row['imageUrl']=ROOT_URL.$row['image'];
				}

				if(isset($row['date_added']))
				$row['date_added']=Render::dateFormat($row['date_added']);	

				if($inputData['isHook']=='yes')
				{
					if(isset($row['content']))
					{
						$row['content']=Shortcode::loadInTemplate($row['content']);
						
						$row['content']=Shortcode::toHTML($row['content']);

					}
					
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


	public function url($row=array())
	{
		return Url::product($row);
	}	

	public function tags($id)
	{
		$resultData=ProductTags::get(array(
			'where'=>"where productid='$id'"
			));

		return $resultData;
	}

	public function downloads($id)
	{
		$resultData=array();

		$query=Database::query("select * from downloads where downloadid IN (select downloadid from products_downloads where productid='$id')");

		$total=Database::num_rows($query);

		if((int)$total > 0)
		{
			while($row=Database::fetch_assoc($query))
			{
				$resultData[]=$row;
			}
		}

		return $resultData;
	}
	public function images($id)
	{
		$resultData=ProductImages::get(array(
			'where'=>"where productid='$id'",
			'orderby'=>"order by sort_order asc"
			));

		return $resultData;
	}

	public function insertDownloads($id,$listDownloads=array())
	{

		if(!isset($listDownloads[0]))
		{
			return false;
		}

		$total=count($listDownloads);

		if((int)$listDownloads[0] > 0)
		for($i=0;$i<$total;$i++)
		{
			$downloadid=$listDownloads[$i];

			ProductDownloads::insert(array(
				'productid'=>$id,
				'downloadid'=>$downloadid
				));
		}

	}

	public function upView($productid)
	{
		Database::query("update products set viewed=viewed+1 where productid='$productid'");
	}

	

	public function insertTags($id,$strTags)
	{
		if(!isset($strTags[1]))
		{
			return false;
		}	
		$listTags=explode(",",$strTags);

		$total=count($listTags);
		
		if(isset($listTags[0][1]))
		for($i=0;$i<$total;$i++)
		{
			$tag=$listTags[$i];

			ProductTags::insert(array(
				'productid'=>$id,
				'title'=>$tag
				));		
		}

	}
	

	public function insertImages($id,$keyName='images')
	{
		$resultData=File::uploadMultiple($keyName,'uploads/images/');

		if(!isset($resultData[0][4]))
		{
			return false;
		}

		$total=count($resultData);

		for($i=0;$i<$total;$i++)
		{
			$theFile=$resultData[$i];

			$insertData=array(
				'productid'=>$id,
				'image'=>$theFile,
				'sort_order'=>$i
				);

			ProductImages::insert($insertData);
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

				$theRow['friendly_url']=String::makeFriendlyUrl($theRow['title']);

				if(isset($theRow['title']))
				$theRow['title']=String::encode($theRow['title']);


				if(isset($theRow['content']))
				{
					$theRow['content']=Shortcode::toBBCode($theRow['content']);

					$theRow['content']=String::encode($theRow['content']);
				}

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

			$inputData['friendly_url']=String::makeFriendlyUrl($inputData['title']);

			if(isset($inputData['title']))
			$inputData['title']=String::encode($inputData['title']);

			if(isset($inputData['content']))
			{
				$inputData['content']=Shortcode::toBBCode($inputData['content']);

				$inputData['content']=String::encode($inputData['content']);
			}

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into products($insertKeys) values".$addMultiAgrs);

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

		$whereQuery=isset($whereQuery[5])?$whereQuery:"productid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from products where $whereQuery $addWhere";

		$loadData=self::get(array(
			'where'=>"where productid in ($listID)"
			));

		if(isset($loadData[0]['productid']))
		{
			$total=count($loadData);

			for ($i=0; $i < $total; $i++) { 
				
				$prod=$loadData[0];

				$imgPath=ROOT_PATH.$prod['image'];

				if(file_exists($imgPath))
				{
					unlink($imgPath);

					$imgPath=dirname($imgPath).'/';

					rmdir($imgPath);
				}

			}
		}

		Database::query($command);

		ProductDownloads::remove($post);

		ProductImages::remove($post);

		ProductTags::remove($post);

		return true;
	}



	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['title']))
		{
			$post['title']=String::encode($post['title']);

			$post['friendly_url']=String::makeFriendlyUrl($post['title']);

			$loadPage=self::get(array(
				'where'=>"where friendly_url='".$post['friendly_url']."'"
				));

			if(isset($loadPage[0]['productid']) && $loadPage[0]['productid']<>$listID[0])
			{
				return false;
			}
		}		

		if(isset($post['content']))
		{
			
			$post['content']=Shortcode::toBBCode($post['content']);

			$post['content']=String::encode(strip_tags($post['content'],'<p><br>'));

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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"productid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update products set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>