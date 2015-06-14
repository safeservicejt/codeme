<?php

$pageName='home';

$pageData=array();

$headData=GlobalCMS::$setting;

$pageData['content_top']=Render::content_top($pageName);

$pageData['content_left']=Render::content_left($pageName);

$pageData['content_right']=Render::content_right($pageName);

$pageData['content_bottom']=Render::content_bottom($pageName);

Theme::model('home');

$curPage=0;

if($matches=Uri::match('page\/(\d+)'))
{
	$curPage=$matches[1];
}

$pageData['newPost']=Post::get(array(
	'limitPage'=>$curPage,
    'limitShow'=>10,
    'orderby'=>'order by date_added desc'
    ));

$pageData['listPage']=listPage();

// print_r(GlobalCMS::$setting);die();

Theme::view('head',$headData);

Theme::view($pageName,$pageData);

Theme::view('footer');

?>