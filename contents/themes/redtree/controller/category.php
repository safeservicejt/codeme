<?php

if(!$match=Uri::match('category-(\d+)\/?'))
{
	Redirect::to('404page');
	// Alert::make('Page not found');
}

$pageName='category';

$pageData=array();

$pageData['content_top']=Render::content_top($pageName);

$pageData['content_left']=Render::content_left($pageName);

$pageData['content_right']=Render::content_right($pageName);

$pageData['content_bottom']=Render::content_bottom($pageName);

Theme::model('category');

$headData=GlobalCMS::$setting;

$pageData['newPost']=searchResult($match[1]);

$pageData['listPage']=listPage();

Theme::view('head',$headData);

Theme::view($pageName,$pageData);

Theme::view('footer');

?>