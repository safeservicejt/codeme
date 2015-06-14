<?php

class JS
{
	/*
	JS::make(array(
	'text'=>'http://ggle.com',
	'link'=>'facegddf'
	))->get();

	JS::select('div.box')		

	*/


	private static $jsCMD='';

	private static $selectMethod='id'; // id|tagname|classname

	private static $dbCMD=array();


	// public function 

	public function select($keyName)
	{
		self::$dbCMD['method']='select';

		self::$dbCMD['selectName']='document.querySelector("'.$keyName.'")';

		return new static;
	}

	public function style($keyName,$keyValue)
	{
		$replace=array(
			'background-color'=>'setBgColor',
			'display'=>'setDisplay'
			);

		$effectName=$replace[$keyName];

		self::$dbCMD['effect'][$effectName]['value']=$keyValue;

		self::$dbCMD['effect'][$effectName]['action']='callwithvalue';

		return $this;
	}

	public function fadeIn()
	{
		self::$dbCMD['effect']['setFadein']['value']='';
		self::$dbCMD['effect']['setFadein']['action']='callnovalue';

		return $this;		
	}

	public function text()
	{
		self::$dbCMD['effect']['getText']['value']='';
		self::$dbCMD['effect']['getText']['action']='callnovalue';
		return $this;		
	}

	public function html()
	{
		self::$dbCMD['effect']['getText']['value']='';
		self::$dbCMD['effect']['getText']['action']='callnovalue';
		return $this;		
	}

	public function addClass()
	{
		self::$dbCMD['effect']['addClass']['value']='';
		self::$dbCMD['effect']['addClass']['action']='callnovalue';
		return $this;		
	}
	public function addClass()
	{
		self::$dbCMD['effect']['addClass']['value']='';
		self::$dbCMD['effect']['addClass']['action']='callnovalue';
		return $this;		
	}

	public function make($keyName,$keyValue='')
	{
		self::$dbCMD['method']='create';

		if(!is_array($keyName))
		{
			self::$dbCMD['variable'][$keyName]=$keyValue;
		}
		else
		{
			self::$dbCMD['variable']=$keyName;
		}

		// print_r(self::$dbCMD);die();

		return new static;
	}

	public function get($show=0)
	{
		// print_r(self::$dbCMD);die();		
		$result=$this->parseQuery();

		if((int)$show==1)
		{
			echo $result;
		}
		else
		{
			return $result;
		}
	}

	public function open()
	{
		echo '<script type="text/javascript">';
	}

	public function close()
	{
		echo '</script>';
	}

	private function parseQuery()
	{
		switch (self::$dbCMD['method']) {
			case 'create':
				$result=$this->parseCreate();
				break;
			case 'select':
				$result=$this->parseSelect();
				break;
			
		}

		return $result;
	}

	private function parseSelect()
	{
		$query=self::$dbCMD['selectName'];

		if(!isset(self::$dbCMD['effect']))
		{
			$result=$query;
		}
		else
		{

		}

		return $result;
	}

	private function parseCreate()
	{
		$total=count(self::$dbCMD['variable']);

		$keyNames=array_keys(self::$dbCMD['variable']);

		$li='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];

			$keyValue=self::$dbCMD['variable'][$keyName];

			if(is_numeric($keyValue))
			{
				$li.="var $keyName=$keyValue;\r\n";	
			}
			else
			{
				$li.="var $keyName='$keyValue';\r\n";	
			}
			
		}

		return $li;
	}




}

?>