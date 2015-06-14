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
			Currency::remove($id);
			break;
		
	}
}

function updateProcess($id)
{
	$update=Request::get('update');

	$valid=Validator::make(array(
		'update.title'=>'min:1|slashes',
		'update.code'=>'min:1|slashes',
		'update.symbolLeft'=>'slashes',
		'update.symbolRight'=>'slashes',
		'update.dataValue'=>'min:1|slashes'		
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	Currency::update($id,$update);
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1|slashes',
		'send.code'=>'min:1|slashes',
		'send.symbolLeft'=>'slashes',
		'send.symbolRight'=>'slashes',
		'send.dataValue'=>'min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}


	if(!$id=Currency::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

}

?>