<?php

class PluginsApi
{

	public function get($foldername)
	{
		if(!$match=Uri::match($foldername.'\/(\w+)'))
		{
			throw new Exception("Not match valid route.");
		}

		$routeName=$match[1];

		$pluginPath=PLUGINS_PATH.$foldername.'/api.php';

		define("THIS_URL",PLUGINS_PATH.$foldername.'/');

		define("THIS_PATH",PLUGINS_PATH.$foldername.'/');

		if(!file_exists($pluginPath))
		{
			return false;
		}

		include($pluginPath);

		$routes=SelfApi::route();

		if(!isset($routes[$routeName]))
		{
			throw new Exception("Plugin not support this route.");
		}

		$func=$routes[$routeName];

		$result=SelfApi::$func();

		return $result;
	}
}
?>