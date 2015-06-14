<?php

if(!Uri::has('^page\-\d+\-.*?\.html'))
{
	Redirect::to('404page');
}

$pageName='page';

$pageData=array();

$pageData['content_top']=Render::content_top($pageName);

$pageData['content_left']=Render::content_left($pageName);

$pageData['content_right']=Render::content_right($pageName);

$pageData['content_bottom']=Render::content_bottom($pageName);

$headData=GlobalCMS::$setting;

Theme::model('page');

$pageData['alert']='';

$pageData=pageProcess($pageData);

if(isset($pageData['keywords']))
{
	$headData['keywords']=$pageData['keywords'];
}

$headData['title']=$pageData['title'];

if($pageData['page_type']=='fullwidth')
{
	$pageName='pageFullWidth';
}

Theme::view('head',$headData);

Theme::view($pageName,$pageData);

Theme::view('footer');
?>