<?php

class System
{
	public static $listVar=array('global'=>array());

	public static function defineVar($keyName,$keyVal,$layout='global')
	{
		self::$listVar[$layout][$keyName]=$keyVal;
	}

	public static function defineGlobalVar($keyName,$keyVal)
	{
		self::defineVar($keyName,$keyVal);
	}

	public static function getVar($keyName,$zoneName='global')
	{
		if(!isset(self::$listVar[$zoneName][$keyName]))
		{
			return false;
		}

		return self::$listVar[$zoneName][$keyName];
	}
	
	public static function isMobile()
	{
		$detect = new Mobile_Detect;

		$deviceType = $detect->isMobile()?true:false;

		return $deviceType;
	}

	public static function deviceType()
	{
		$detect = new Mobile_Detect;

		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
		
		return $deviceType;
	}

	public static function deviceVersion()
	{
		$detect = new Mobile_Detect;

		$scriptVersion = $detect->getScriptVersion();

		return $scriptVersion;
	}
	



}

?>