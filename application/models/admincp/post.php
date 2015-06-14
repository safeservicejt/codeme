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
			Post::remove($id);

			PostTags::remove($id," postid IN ($listID) ");

			break;
		case 'publish':

			Post::update($id,array(
				'status'=>1
				));
			break;
		case 'unpublish':
			Post::update($id,array(
				'status'=>0
				));
			break;
		case 'featured':
		$today=date('Y-m-d h:i:s');
			Post::update($id,array(
				'is_featured'=>1,
				'date_featured'=>$today
				));
			break;
		case 'unfeatured':
			Post::update($id,array(
				'is_featured'=>0
				));
			break;
		case 'allowcomment':
			Post::update($id,array(
				'allowcomment'=>1
				));
			break;
		case 'unallowcomment':
			Post::update($id,array(
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
		'send.keywords'=>'slashes',
		'tags'=>'slashes',
		'send.catid'=>'slashes',
		'send.type'=>'slashes',
		'send.allowcomment'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request. Error: ".Validator::$message);
	}

	$uploadMethod=Request::get('uploadMethod');


	$loadData=Post::get(array(
		'where'=>"where postid='$id'"
		));

	if(!isset($loadData[0]['postid']))
	{
		throw new Exception("This post not exists.");
		
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

	$send['userid']=Session::get('userid');

	if(!Request::has('send.catid'))
	{
		$loadCat=Categories::get(array(
			'limitShow'=>1
			));

		if(isset($loadCat[0]['catid']))
		{
			$send['catid']=$loadCat[0]['catid'];
		}
	}


	if(!Post::update($id,$send))
	{
		throw new Exception("Error. ".Database::$error);
	}

	PostTags::remove($id," postid='$id' ");

	$tags=trim(Request::get('tags'));

	$parse=explode(',', $tags);

	$total=count($parse);

	$insertData=array();

	for ($i=0; $i < $total; $i++) { 
		$insertData[$i]['title']=trim($parse[$i]);
		$insertData[$i]['postid']=$id;
	}

	PostTags::insert($insertData);
	
}

function insertProcess()
{
	$send=Request::get('send');

	$valid=Validator::make(array(
		'send.title'=>'min:1|slashes',
		'send.keywords'=>'slashes',
		'tags'=>'slashes',
		'send.catid'=>'slashes',
		'send.type'=>'slashes',
		'send.allowcomment'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
	}

	$friendlyUrl=trim(String::makeFriendlyUrl($send['title']));

	$getData=Post::get(array(
		'where'=>"where friendly_url='$friendlyUrl'"
		));

	if(isset($getData[0]['postid']))
	{
		throw new Exception("This post exists in database.");
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

	$send['userid']=Session::get('userid');

	if(!Request::has('send.catid'))
	{
		$loadCat=Categories::get(array(
			'limitShow'=>1
			));

		if(isset($loadCat[0]['catid']))
		{
			$send['catid']=$loadCat[0]['catid'];
		}
	}


	if(!$id=Post::insert($send))
	{
		throw new Exception("Error. ".Database::$error);
	}

	$tags=trim(Request::get('tags'));

	$parse=explode(',', $tags);

	$total=count($parse);

	$insertData=array();

	for ($i=0; $i < $total; $i++) { 
		$insertData[$i]['title']=trim($parse[$i]);
		$insertData[$i]['postid']=$id;
	}

	PostTags::insert($insertData);

}

?>