<?php

class Cashondelivery
{

	public function install()
	{
		Paymentmethods::install('func_name');
	}

	public function setting()
	{

	}

	public function orderRequire()
	{

	}

	public function checkoutProcess()
	{
		$resultData=array(
			'status'=>'completed'
			);

		return $resultData;		
	}
}


?>