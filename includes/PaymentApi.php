<?php

class PaymentApi
{

	public function get($foldername)
	{
		if(!$match=Uri::match($foldername.'\/(\w+)'))
		{
			throw new Exception("Not match valid route.");
		}

		$routeName=$match[1];

		$pluginPath=ROOT_PATH.'contents/paymentmethods/'.$foldername.'/api.php';

		if(!file_exists($pluginPath))
		{
			return false;
		}

		include($pluginPath);

		$routes=SelfApi::route();

		if(!isset($routes[$routeName]))
		{
			throw new Exception("Payment method not support this route.");
		}

		$func=$routes[$routeName];

		$result=SelfApi::$func();

		return $result;
	}
}
?>