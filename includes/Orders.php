<?php

class Orders
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

		$field="orderid,customerid,payment_firstname,payment_lastname,payment_company,payment_address_1,payment_address_2,payment_city,payment_postcode,payment_country,payment_method,payment_email,payment_phone,payment_fax,shipping_firstname,shipping_lastname,shipping_company,shipping_address_1,shipping_address_2,shipping_city,shipping_postcode,shipping_country,shipping_method,shipping_phone,shipping_fax,comment,total,total_products,affiliate_id,commission,ip,date_added,date_modified,isreaded,status,tax_rate,vat_rate";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by orderid desc';

		$result=array();
		
		$command="select $selectFields from orders $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		// Load dbcache

		// $loadCache=DBCache::get($queryCMD);

		// if($loadCache!=false)
		// {
		// 	return $loadCache;
		// }

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

				if(isset($row['comment']))
				{
					$row['comment']=String::decode($row['comment']);
				}	
							
				if(isset($row['total']))
				{
					$getData=Currency::parsePrice($row['total']);

					$row['total']=$getData['real'];

					$row['totalFormat']=$getData['format'];
				}
				if(isset($row['tax_rate']))
				{
					$getData=Currency::parsePrice($row['tax_rate']);

					$row['tax_rate']=$getData['real'];

					$row['tax_rateFormat']=$getData['format'];
				}
				if(isset($row['vat_rate']))
				{
					$getData=Currency::parsePrice($row['vat_rate']);

					$row['vat_rate']=$getData['real'];

					$row['vat_rateFormat']=$getData['format'];
				}
				
				$row['date_addedFormat']=isset($row['date_added'])?Render::dateFormat($row['date_added']):'';				
										
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		// Save dbcache
		// DBCache::make(md5($queryCMD),$result);
		// end save

		return $result;
		
	}	


	public function api($action)
	{
		Model::load('api/order');

		try {
			loadApi($action);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}



	public function insert($inputData=array())
	{
		$inputData['comment']=strip_tags($inputData['comment']);

		if(isset($inputData['comment']))
		{
			$inputData['comment']=String::encode($inputData['comment']);
		}

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into orders($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			// Multidb::increasePost();			
			
			return $id;		
		}

		return false;
	
	}

	public function insertAffiliate($orderid)
	{
		if(!Session::has('affiliateid'))
		{
			return true;
		}

		$aid=Session::get('affiliateid');

		if((int)$aid==0)
		{
			return false;
		}

		$loadData=Affiliate::get(array(
			'where'=>"where userid='$aid'"
			));

		if(!isset($loadData[0]['userid']))
		{
			return false;
		}

		$commission=$loadData[0]['commission'];

		if((double)$commission==0)
		{
			return true;
		}

		$post=array(
			'affiliate_id'=>$aid,
			'commission'=>$commission
			);

		Orders::update($orderid,$post);
	}

	public function insertProducts($inputData=array())
	{
		// if(isset($inputData['price']))
		// {
		// 	$inputData['price']=Currency::insertPrice($inputData['price']);
		// }

		$keyNames=array_keys($inputData);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($inputData);

		$insertValues="'".implode("','", $keyValues)."'";

		Database::query("insert into orders_products($insertKeys) values($insertValues)");

		if(!$error=Database::hasError())
		{
			// $id=Database::insert_id();

			
			// return $id;	

			return true;	
		}

		return false;
	
	}

	public function products($orderid)
	{
		$command="select orderid,productid,quantity,price,downloads from orders_products $whereQuery";

		$query=Database::query($command);
		
		// $query=Database::query("select op.orderid,op.productid,op.quantity,op.price,op.downloads,p.title from orders_products op,products p where op.productid=p.productid AND op.orderid='$orderid'");

		$total=Database::num_rows($query);

		$resultData=array();

		$i=0;

		if((int)$total > 0)
		{
			while($loadData=Database::fetch_assoc($query))
			{
				$prodData=Products::get(array(
					'where'=>"where productid='".$loadData[0]['productid']."'"
					));

				if(!isset($prodData[0]['productid']))
				{
					continue;
				}

				$loadData['title']=$prodData[0]['title'];

				$resultData[$i]=$loadData;

				$getData=Currency::parsePrice($resultData[$i]['price']);

				$resultData[$i]['price']=$getData['real'];

				$resultData[$i]['priceFormat']=$getData['format'];

				$i++;
		
			}

			return $resultData;
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

		$orders=Multidb::renderDb('orders');

		$whereQuery=isset($whereQuery[5])?$whereQuery:"orderid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from orders where $whereQuery $addWhere";

		Database::query($command);	
		
		$command="delete from orders_products where orderid in ($listID)";

		Database::query($command);	

		return true;
	}

	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{
		if(isset($post['comment']))
		{
			$post['comment']=String::encode($post['comment']);
		}		
		
		if(isset($post['total']))
		{
			$post['total']=Currency::insertPrice($post['price']);
		}
		if(isset($post['tax_rate']))
		{
			$post['tax_rate']=Currency::insertPrice($post['tax_rate']);
		}
		if(isset($post['vat_rate']))
		{
			$post['vat_rate']=Currency::insertPrice($post['vat_rate']);
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
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"orderid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update orders set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>