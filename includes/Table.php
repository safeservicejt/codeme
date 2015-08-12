<?php

/*

class Test extends Table
{
	public $table='users';

	public $id='userid';

	public $fields='userid,groupid,username,firstname,lastname,image,email,password,userdata,ip,verify_code,parentid,date_added,forgot_code,forgot_date';

	public function __construct()
	{
		

	}

}


*/

class Table
{
	public $table='';

	public $id='';

	public $fields='';

	public function __construct()
	{
		
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

		$field=$this->fields;

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$groupBy=isset($inputData['groupby'])?$inputData['groupby']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by '.$this->id.' desc';

		$result=array();
		
		$command="select $selectFields from ".$this->table." $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:1;


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
		
		// Save dbcache
		DBCache::make(md5($queryCMD),$result);
		// end save

		return $result;

	}

	public function all()
	{

		$loadData=$this->get();

		return $loadData;
	}

	public function first()
	{
		$loadData=$this->get(array(
			'limitShow'=>1,
			'orderby'=>'order by '.$this->$id.' asc'
			));

		return $loadData;		
	}

	public function last()
	{
		$loadData=$this->get(array(
			'limitShow'=>1
			));

		return $loadData;
	}

	public function up($keyName='',$total=1)
	{
		if(!isset($keyName[1]))
		{
			return false;
		}

		Database::query("update ".$this->$table." set $keyName=$keyName+$total");
	}

	public  function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';



		if(is_array($inputData[0]))
		{
		    foreach ($inputData as $theRow) {


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
			

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into ".$this->table."($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	
	}

	public  function remove($queryCMD='')
	{

		$command="delete from ".$this->table.' '.$queryCMD;

		Database::query($command);	

		return true;
	}

	public function addField($keyName='',$inputData=array())
	{

		$status=Database::addField($this->table,$keyName,$inputData);

		return $status;
	}

	public function dropField($keyName='')
	{
		Database::dropField($this->table,$keyName);

	}

	public  function update($inputData=array(),$queryCMD='')
	{

		$listIDs="'".implode("','",$listID)."'";		
				
		$keyNames=array_keys($inputData);

		$total=count($inputData);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$inputData[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);

		Database::query("update ".$this->table." set $setUpdates where ".$queryCMD);

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}

?>