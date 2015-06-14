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
			Categories::remove($id);
			break;
		
	}
}

function updateProcess($id)
{
	$update=Request::get('update');

	$valid=Validator::make(array(
		'update.title'=>'required|min:1|slashes',
		'update.parentid'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	if(Request::hasFile('image'))
	{
		if(Request::isImage('image'))
		{
			$update['image']=File::upload('image');

			$loadData=Categories::get(array(
				'where'=>"where catid='$id'"
				));

			if(isset($loadData[0]['catid']))
			{
				File::remove($loadData[0]['image']);
			}
		}
	}

	Categories::update($id,$update);
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'required|min:1|slashes',
		'send.parentid'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	if(Request::hasFile('image'))
	{
		if(Request::isImage('image'))
		{
			$send['image']=File::upload('image');
		}
	}

	if(!$id=Categories::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

}

?>