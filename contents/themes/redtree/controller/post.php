<?php

if(!isset($_RESQUEST['id']))
{
	if(!$match=Uri::match('^post\-(\d+)\-.*?\.html'))
	{
		Redirect::to('404page');
	}	

	$_RESQUEST['id']=$match[1];

	$id=$match[1];
}
else
{
	$id=$_RESQUEST['id'];
}

// print_r($_RESQUEST['id']);die();

$pageName='post';

$pageData=array();

$pageData['content_top']=Render::content_top($pageName);

$pageData['content_left']=Render::content_left($pageName);

$pageData['content_right']=Render::content_right($pageName);

$pageData['content_bottom']=Render::content_bottom($pageName);

Theme::model('post');

$headData=GlobalCMS::$setting;

$pageData['commentAlert']=sendComment();

// $pageData['categories']=categories();

$pageData=postProcess($pageData);

$pageData['listComments']=listComments($id);

$headData['title']=$pageData['title'];

Theme::view('head',$headData);

Theme::view($pageName,$pageData);

Theme::view('footer');

?>