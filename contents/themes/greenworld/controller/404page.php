<?php

$pageName='home';

$pageData=array();

$headData=GlobalCMS::$setting;

$pageData['content_top']=Render::content_top($pageName);

$pageData['content_left']=Render::content_left($pageName);

$pageData['content_right']=Render::content_right($pageName);

$pageData['content_bottom']=Render::content_bottom($pageName);


// print_r(GlobalCMS::$setting);die();

Theme::view('head',$headData);

Theme::view('404page',$pageData);

Theme::view('footer');

?>