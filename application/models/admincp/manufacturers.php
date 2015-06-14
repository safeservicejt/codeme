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
			Manufacturers::remove($id);
			break;
		
	}
}

function updateProcess($id)
{
	$update=Request::get('update');

	$valid=Validator::make(array(
		'update.title'=>'required|min:1|slashes'
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

			$loadData=Manufacturers::get(array(
				'where'=>"where mid='$id'"
				));

			if(isset($loadData[0]['mid']))
			{
				File::remove($loadData[0]['image']);
			}
		}
	}

	Manufacturers::update($id,$update);
	
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

	if(!$id=Manufacturers::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

}

?>