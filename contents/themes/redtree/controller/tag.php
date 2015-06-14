<?php

if(!$match=Uri::match('tag-\w+'))
{
	Alert::make('Page not found');
}

$pageName='home';

$pageData=array();

$pageData['content_top']=Render::content_top($pageName);

$pageData['content_left']=Render::content_left($pageName);

$pageData['content_right']=Render::content_right($pageName);

$pageData['content_bottom']=Render::content_bottom($pageName);

Theme::model('tag');

$headData=GlobalCMS::$setting;

// $pageData['categories']=categories();

$keyword='';

$pageData['newPost']=searchResult();

$parseData=listPage();

$pageData['listPage']=$parseData['pages'];

$pageData['keywords']=$parseData['keywords'];

Theme::view('head',$headData);

Theme::view('tag',$pageData);

Theme::view('footer');

?>