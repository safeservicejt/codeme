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
			Coupons::remove($id);
			break;
		
	}
}

function updateProcess($id)
{
	$update=Request::get('update');

	$valid=Validator::make(array(
		'update.title'=>'min:1|slashes',
		'update.type'=>'min:1|slashes',
		'update.freeshipping'=>'min:1|slashes',
		'update.amount'=>'min:1|slashes',
		'update.date_start'=>'min:1|slashes',
		'update.date_end'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	Coupons::update($id,$update);
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1|slashes',
		'send.type'=>'min:1|slashes',
		'send.freeshipping'=>'min:1|slashes',
		'send.amount'=>'min:1|slashes',
		'send.date_start'=>'min:1|slashes',
		'send.date_end'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}


	if(!$id=Coupons::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

}

?>