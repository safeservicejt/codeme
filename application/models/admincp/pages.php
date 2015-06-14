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
			Pages::remove($id);

			break;
		case 'publish':

			Pages::update($id,array(
				'status'=>1
				));
			break;
		case 'unfeatured':
			Pages::update($id,array(
				'is_featured'=>0
				));
			break;
		case 'allowcomment':
			Pages::update($id,array(
				'allowcomment'=>1
				));
			break;
		case 'unallowcomment':
			Pages::update($id,array(
				'allowcomment'=>0
				));
			break;
		
	}
}

function updateProcess($id)
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1|slashes',
		'send.content'=>'min:1|slashes',
		'send.keywords'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	$uploadMethod=Request::get('uploadMethod');


	$loadData=Pages::get(array(
		'where'=>"where pageid='$id'"
		));

	if(!isset($loadData[0]['pageid']))
	{
		throw new Exception("This page not exists.");
		
	}

	switch ($uploadMethod) {
		case 'frompc':
			if(Request::hasFile('imageFromPC'))
			{
				if(Request::isImage('imageFromPC'))
				{
					$send['image']=File::upload('imageFromPC');

					File::remove($loadData[0]['image']);
				}
			}
			break;
		case 'fromurl':

			if(Request::isImage('imageFromUrl'))
			{
				$url=Request::get('imageFromUrl');

				$send['image']=File::upload('uploadFromUrl');

				File::remove($loadData[0]['image']);
			}

			break;
	}


	if(!Pages::update($id,$send))
	{
		throw new Exception("Error. ".Database::$error);
	}
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1|slashes',
		'send.content'=>'min:1|slashes',
		'send.keywords'=>'slashes',
		'send.page_type'=>'slashes',
		'send.allowcomment'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	$friendlyUrl=trim(String::makeFriendlyUrl($send['title']));

	$getData=Pages::get(array(
		'where'=>"where friendly_url='$friendlyUrl'"
		));

	if(isset($getData[0]['pageid']))
	{
		throw new Exception("This page exists in database.");
	}

	$uploadMethod=Request::get('uploadMethod');

	switch ($uploadMethod) {
		case 'frompc':
			if(Request::hasFile('imageFromPC'))
			{
				if(Request::isImage('imageFromPC'))
				{
					$send['image']=File::upload('imageFromPC');
				}
			}
			break;
		case 'fromurl':

			if(Request::isImage('imageFromUrl'))
			{
				$url=Request::get('imageFromUrl');

				$send['image']=File::upload('uploadFromUrl');
			}

			break;
	}

	if(!$id=Pages::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

}

?>