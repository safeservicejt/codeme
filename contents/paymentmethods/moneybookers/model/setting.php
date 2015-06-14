<?php


function settingProcess()
{
	$alert='<div class="alert alert-warning">Error. Check information again, pls!</div>';

	$valid=Validator::make(array(
		'send.email'=>'email|slashes',
		'send.secret'=>'slashes',
		'send.order_status'=>'slashes',
		'send.pending_status'=>'slashes',
		'send.cancelled_status'=>'slashes',
		'send.failed_status'=>'slashes',
		'send.chargeback_status'=>'slashes'

		));

	if(!$valid)
	{
		return $alert;
	}

	$saveData=json_encode(Request::get('send'));

	File::create(PAYMENTMETHOD_PATH.'setting.json',$saveData);

	$alert='<div class="alert alert-success">Completed. Save changes success!</div>';	

	return $alert;

}

function settingData()
{
	$filePath=PAYMENTMETHOD_PATH.'setting.json';

	if(!file_exists($filePath))
	{
		return false;
	}

	$loadData=file_get_contents($filePath);

	$loadData=json_decode($loadData,true);

	return $loadData;
}

?>