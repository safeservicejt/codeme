<?php

function actionProcess()
{
	$id=Request::get('id');

	if(!isset($id[0]))
	{
		return false;
	}

	$listID="'".implode("','", $id)."'";

	$action=Request::get('action');

	// die($action);

	switch ($action) {
		case 'delete':
			Vouchers::remove($id);
			break;
		
	}
}

function updateProcess($id)
{
	$update=Request::get('update');

	$valid=Validator::make(array(
		'send.amount'=>'min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	$amount=Request::get('update.amount');

	preg_match('/(\d+[\.\d]+)/i', $amount,$match);

	$update['amount']=(double)$match[1];

	Vouchers::update($id,$update);
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.amount'=>'min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	$amount=Request::get('send.amount');

	preg_match('/(\d+[\.\d]+)/i', $amount,$match);

	$send['amount']=(double)$match[1];

	$send['code']=String::randNumber(12);

	if(!$id=Vouchers::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

}

?>