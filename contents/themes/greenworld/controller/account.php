<?php

$pageName='home';

$pageData=array();

$pageData['content_top']=Render::content_top($pageName);

$pageData['content_left']=Render::content_left($pageName);

$pageData['content_right']=Render::content_right($pageName);

$pageData['content_bottom']=Render::content_bottom($pageName);

$headData=GlobalCMS::$setting;

Theme::view('head',$headData);

Theme::view($pageName,$pageData);

Theme::view('footer');

?>