<?php

class LINQ
{
// $rows=LINQ::table('users')->select(array('username','password'))->where('uid','>','3')->get();
// $rows=LINQ::table('users')->select(array('username','password'))->whereIn('uid',array(3,4))->get();
// $rows=LINQ::table('users')->select(array('username','password'))->whereBetween('uid','14/08/1990|14/08/2014')->get();
// $rows=LINQ::table('users')->select(array('username','password'))->whereNotBetween('uid','14/08/1990|14/08/2014')->get();
// $rows=LINQ::table('users')->select(array('username','password'))->where('uid','>','3')->orWhere('uid','>','4')->get();
// $rows=LINQ::table('users')->select(array('username','password'))->where('uid','>','3')->andWhere('uid','>','4')->get();
// $rows=LINQ::table('users')->select(array('username','password'))->where('uid','>','3')->andWhere('uid','>','4')->orWhere('uid','>','4')->get();
// $rows=LINQ::table('users')->select(array('username','password'))->whereNotIn('uid',array(3,4))->get();
// $rows=LINQ::table('users')->with('categories','catid','catid')->with('pages','prodid','prodid')->get();
// $rows=LINQ::table('users')->select(array('users.username as uname'))->with('categories','catid','catid')->with('pages','prodid','prodid')->get();
// $rows=LINQ::table('users')->select(array('username','password'))->where('uid','>','3')->offset(1)->take(5)->get();

// Update data
// $rows=LINQ::table('users')->where('uid','>','3')->update(array(
// 	'data'=>array(
// 		'password'=>'minhtien'
// 		)
// 	));

// Delete data
// $rows=LINQ::table('users')->where('uid','>','3')->delete();

// Insert data
// LINQ::table('users')->insert(array(
// 	'data'=>array(
// 		'username'=>'15y5y5yh54y45',
// 		'password'=>md5('minhtien')
// 		)
// 	));

	private static $query=array();

	public function table($tableName='')
	{
		if(!isset($tableName[1]))
		{
			return false;
		}

		self::$query['table']=$tableName;

		self::$query['action']='get';

		return new static;    

	}

	public function with($tableName,$primaryKey,$foreignKey)
	{
		if(!isset($tableName[1]))
		{
			return false;
		}

		$total=isset($this->query['withTable'])?count($this->query['withTable']):0;

		$this->query['withTable'][$total]['name']=$tableName;

		$this->query['withTable'][$total]['primaryKey']=$primaryKey;

		$this->query['withTable'][$total]['foreignKey']=$foreignKey;

		return $this;		
	}

	public function select($listFields=array())
	{
		$this->query['fields']=$listFields;

		return $this;
	}

	public function update($listFields=array())
	{
		$mainTable=self::$query['table'];

		$total=count($listFields['data']);

		if($total==0)
		{
			return false;
		}

		$keyNames=array_keys($listFields['data']);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{

			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='".$listFields['data'][$keyName]."', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);

		$whereQuery=$this->parseWhere();

		$resultData="update $mainTable set $setUpdates $whereQuery";

		$query=Database::query($resultData);

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}
	public function delete()
	{
		$mainTable=self::$query['table'];

		$whereQuery=$this->parseWhere();

		$resultData="delete from $mainTable $whereQuery";

		$query=Database::query($resultData);

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}

	public function insert($listFields=array())
	{
		$mainTable=self::$query['table'];

		$total=count($listFields['data']);

		if($total==0)
		{
			return false;
		}

		$keyNames=array_keys($listFields['data']);

		$insertKeys=implode(',', $keyNames);

		$keyValues=array_values($listFields['data']);

		$insertValues="'".implode("','", $keyValues)."'";

		// $whereQuery=$this->parseWhere();

		$resultData="insert into $mainTable($insertKeys) values($insertValues)";

		Database::query($resultData);

		if(!$error=Database::hasError())
		{
			return true;
		}		

		return false;
	}

	// Query action

	public function get()
	{
		$loadData=$this->excuteQuery();

		return $loadData;
	}

	public function count($fieldName)
	{
		$fieldName=isset($fieldName[1])?$fieldName:'*';

		$this->query['fields']=" count($fieldName)as totalRow ";

		$loadData=$this->excuteQuery();

		return $loadData[0]['totalRow'];
	}

	public function min($fieldName)
	{
		$fieldName=isset($fieldName[1])?$fieldName:'*';

		$this->query['fields']=" MIN($fieldName)as totalRow ";

		$loadData=$this->excuteQuery();

		return $loadData[0]['totalRow'];
	}

	public function max($fieldName)
	{
		$fieldName=isset($fieldName[1])?$fieldName:'*';

		$this->query['fields']=" MAX($fieldName)as totalRow ";

		$loadData=$this->excuteQuery();

		return $loadData[0]['totalRow'];
	}

	public function sum($fieldName)
	{
		$fieldName=isset($fieldName[1])?$fieldName:'*';

		$this->query['fields']=" SUM($fieldName)as totalRow ";

		$loadData=$this->excuteQuery();

		return $loadData[0]['totalRow'];
	}
	
	public function query($str)
	{
		$this->query['query']=$str;

		return $this;
	}

	public function orderBy($keyName,$method)
	{
		$this->query['orderby']="order by $keyName $method";

		return $this;
	}
	
	public function groupBy($keyName)
	{
		$this->query['groupby']="group by $keyName";

		return $this;
	}

	public function offset($num)
	{
		$this->query['limit']['offset']=$num;

		return $this;
	}

	public function take($num)
	{
		$this->query['limit']['take']=$num;

		return $this;
	}

	public function where($fieldName,$conditionName,$conditionValue)
	{
		$loadData=$this->setWhere('',$fieldName,$conditionName,$conditionValue);

		return $loadData;
	}
	public function orWhere($fieldName,$conditionName,$conditionValue)
	{
		$loadData=$this->setWhere('OR',$fieldName,$conditionName,$conditionValue);

		return $loadData;
	}
	public function andWhere($fieldName,$conditionName,$conditionValue)
	{
		$loadData=$this->setWhere('AND',$fieldName,$conditionName,$conditionValue);

		return $loadData;
	}
	public function whereBetween($fieldName,$conditionValue)
	{
		$loadData=$this->setWhere('',$fieldName,'BETWEEN',$conditionValue);

		return $loadData;
	}
	public function whereNotBetween($fieldName,$conditionValue)
	{
		$loadData=$this->setWhere('',$fieldName,'NOT BETWEEN',$conditionValue);

		return $loadData;
	}
	public function whereIn($fieldName,$conditionValue=array())
	{
		$listIn="'".implode("','", $conditionValue)."'";

		$loadData=$this->setWhere('',$fieldName,'IN',$listIn);

		return $loadData;
	}
	public function whereNotIn($fieldName,$conditionValue=array())
	{
		$listIn="'".implode("','", $conditionValue)."'";

		$loadData=$this->setWhere('',$fieldName,'NOT IN',$listIn);

		return $loadData;
	}

	public function setWhere($beforeWhere='',$fieldName,$conditionName,$conditionValue)
	{
		$conditionName=strtolower($conditionName);

		switch ($conditionName) {
			case 'like':
				$conditionValue="'%$conditionValue%'";
				break;
			case 'in':
				$conditionValue="($conditionValue)";
				break;
			case 'not in':
				$conditionValue="($conditionValue)";
				break;
			case 'between':
				$parse=explode('|', $conditionValue);

				$conditionValue="'$parse[0]' AND '$parse[1]'";
				break;
			case 'notbetween':
				$parse=explode('|', $conditionValue);

				$conditionValue="'$parse[0]' AND '$parse[1]'";
				break;
			default:
				$conditionValue="'$conditionValue'";
				break;

		}

		$total=isset($this->query['where'][$conditionName])?count($this->query['where'][$conditionName]):0;

		$this->query['where'][$conditionName][$total]['before']=$beforeWhere;

		$this->query['where'][$conditionName][$total]['field']=$fieldName;
		$this->query['where'][$conditionName][$total]['value']=$conditionValue;

		// print_r($this->query['where']);

		return $this;
	}

	// End Query action

	public function excuteQuery()
	{
		$queryStr=$this->parseQuery();

		$loadData=array();	

		$query=Database::query($queryStr);

		$total=Database::num_rows($query);

		if((int)$total==0)
		{
			return false;
		}
	
		$i=0;

		while($row=Database::fetch_assoc($query))
		{
			$loadData[$i]=$row;

			$i++;
		}



		return $loadData;
	}

	public function parseWhere()
	{
		// print_r($this->query['where']);die();

		$resultData='';

		if(!isset($this->query['where']))
		{
			return $resultData;
		}

		$totalCondition=count($this->query['where']);

		if($totalCondition==0)
		{
			return $resultData;
		}

		$keyNames=array_keys($this->query['where']);

		for($i=0;$i<$totalCondition;$i++)
		{
			$theKey=$keyNames[$i];

			$totalWhere=count($this->query['where'][$theKey]);

			for($j=0;$j<$totalWhere;$j++)
			{
				$field=$this->query['where'][$theKey][$j]['field'];

				$value=$this->query['where'][$theKey][$j]['value'];

				$before=$this->query['where'][$theKey][$j]['before'];

				$resultData.="$before $field $theKey $value ";

			}

			// $resultData.=$this->query['where'][$theKey]

		}

		$resultData=" where $resultData ";

		// $resultData=preg_replace('/ (\w+\.\w+) = \'(\w+.\w+)\' /i', ' $1 = $2 ', $resultData);

		// print_r($resultData);

		// echo $totalCondition;

		return $resultData;
		
	}
	public function parseFields()
	{
		$listFields='*';

		if(isset($this->query['fields']))
		{
			$listFields=implode(',', $this->query['fields']);
		}

		return $listFields;
	}

	public function parseTables()
	{
		$resultData=self::$query['table'];

		$mainTable=self::$query['table'];

		if(isset($this->query['withTable']))
		{
			$totalWith=count($this->query['withTable']);

			for($i=0;$i<$totalWith;$i++)
			{
				$tableName=$this->query['withTable'][$i]['name'];

				$primaryKey=$this->query['withTable'][$i]['primaryKey'];

				$foreignKey=$this->query['withTable'][$i]['foreignKey'];

				$this->andWhere("$tableName.$primaryKey",'=',"$mainTable.$foreignKey");

				$resultData="$resultData,$tableName";				
			}

		}

		return $resultData;
	}


	public function parseQuery()
	{
		$resultQuery='';

		$tableName=$this->parseTables();

		$action=self::$query['action'];

		$listFields=$this->parseFields();

		$orderBy=isset($this->query['orderby'])?$this->query['orderby']:'';

		$groupBy=isset($this->query['groupby'])?$this->query['groupby']:'';

		$limitFrom=isset($this->query['limit']['offset'])?$this->query['limit']['offset']:0;

		$limitTotal=isset($this->query['limit']['take'])?$this->query['limit']['take']:0;

		$limitSet=((int)$limitTotal > 0)?"limit $limitFrom,$limitTotal":'';

		$whereQuery=$this->parseWhere();

		$resultQuery="select $listFields from $tableName $whereQuery $groupBy $orderBy";

		$resultQuery=isset($this->query['query'])?$this->query['query']:$resultQuery;

		$resultQuery.=" $limitSet";

		$resultQuery=preg_replace('/ where AND /i', ' where ', $resultQuery);		

		$resultQuery=preg_replace('/ (\w+\.\w+) = \'(\w+.\w+)\' /i', ' $1 = $2 ', $resultQuery);

		// die($resultQuery);

		return $resultQuery;
	}
}

?>