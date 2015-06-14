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
			UserGroups::remove($id);

			break;
		
	}
}

function updateProcess($groupid)
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.group_title'=>'min:1|slashes',
		'send.groupdata'=>'min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	$title=trim(Request::get('send.group_title'));


	$content=trim(Request::get('send.groupdata'));

	$updateData=array(
		'group_title'=>$title,
		'groupdata'=>$content
		);

	UserGroups::update($groupid,$updateData);
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.group_title'=>'min:1|slashes',
		'send.groupdata'=>'min:1|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	$title=trim(Request::get('send.group_title'));

	$loadData=UserGroups::get(array(
		'where'=>"where group_title='$title'"
		));

	if(isset($loadData[0]['groupdata']))
	{
		throw new Exception("This group have been exists.");
		
	}

	$content=trim(Request::get('send.groupdata'));

	$insertData=array(
		'group_title'=>$title,
		'groupdata'=>$content
		);

	UserGroups::insert($insertData);

}

?>