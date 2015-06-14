<?php

$pageName='home';

$pageData=array();

$pageData['content_top']=Render::content_top($pageName);

$pageData['content_left']=Render::content_left($pageName);

$pageData['content_right']=Render::content_right($pageName);

$pageData['content_bottom']=Render::content_bottom($pageName);

Theme::model('search');

$headData=GlobalCMS::$setting;

// $pageData['categories']=categories();

$keyword='';

$pageData['newPost']=searchResult();

$parseData=listPage();

$pageData['listPage']=$parseData['pages'];

$pageData['keywords']=$parseData['keywords'];

Theme::view('head',$headData);

Theme::view('search',$pageData);

Theme::view('footer');

?>