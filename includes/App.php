<?php

class App
{

	private static $config=array(

		'locale'=>LANGUAGE

		);

	function __construct()
	{
		$locale=LANGUAGE;

		if(isset($_SESSION['locale']))
		{
			$locale=$_SESSION['locale'];
		}

		self::$config['locale']=$locale;
	}

	public function get($keyName)
	{
		if(!isset(self::$config[$keyName]))
		{
			return false;
		}

		return self::$config[$keyName];
	}

	public function set($keyName,$keyValue)
	{
		if($keyName=='')
		{
			return false;
		}

		self::$config[$keyName]=$keyValue;
	}

	public function setLocale($keyValue)
	{
		if($keyValue=='')
		{
			return false;
		}

		self::$config['locale']=$keyValue;

		$_SESSION['locale']=$keyValue;
	}


}

?>