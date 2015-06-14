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
			Taxrates::remove($id);
			break;
		
	}
}

function updateProcess($id)
{
	$update=Request::get('update');

	$valid=Validator::make(array(
		'update.title'=>'required|min:1|slashes',
		'update.type'=>'min:1|slashes',
		'update.rate'=>'min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	$amount=Request::get('update.rate');

	preg_match('/(\d+[\.\d]+)/i', $amount,$match);

	$update['rate']=(double)$match[1];

	Taxrates::update($id,$update);
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'required|min:1|slashes',
		'send.type'=>'min:1|slashes',
		'send.rate'=>'min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	$amount=Request::get('send.rate');

	preg_match('/(\d+[\.\d]+)/i', $amount,$match);

	$send['rate']=(double)$match[1];

	$country=Request::get('countries');

	$send['country_short']=implode(',', $country);

	if(!$id=Taxrates::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

}

?>