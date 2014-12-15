<?php

class App
{

	private static $config=array(

		'locale'=>'en'

		);


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
	}


}

?>