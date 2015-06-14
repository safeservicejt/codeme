<?php

$pageName='contactus';

$pageData=array();

$headData=GlobalCMS::$setting;

$pageData['content_top']=Render::content_top($pageName);

$pageData['content_left']=Render::content_left($pageName);

$pageData['content_right']=Render::content_right($pageName);

$pageData['content_bottom']=Render::content_bottom($pageName);

Theme::model('contactus');

// print_r(GlobalCMS::$setting);die();

$pageData['alert']='';

if(Request::has('btnSend'))
{
	$pageData['alert']=contactProcess();
}

Theme::view('head',$headData);

Theme::view($pageName,$pageData);

Theme::view('footer');

?>