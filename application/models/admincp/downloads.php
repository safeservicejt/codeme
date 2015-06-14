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
			Downloads::remove($id);
			break;
		
	}
}

function updateProcess($id)
{
	$update=Request::get('update');

	$valid=Validator::make(array(
		'update.title'=>'min:1|slashes',
		'update.remaining'=>'min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	Downloads::update($id,$update);
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1|slashes',
		'send.remaining'=>'min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	if(!$shortPath=File::upload('theFile'))
	{
		throw new Exception("File uploaded not valid.");
		
	}

	$send['filename']=$shortPath;


	if(!$id=Downloads::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

}

?>