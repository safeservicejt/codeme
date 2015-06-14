<?php

if((int)GlobalCMS::$setting['enable_rss']==0)
{
	Alert::make('Page not found');
}

$pageName='rss';

$pageData=array();

$headData=GlobalCMS::$setting;

Theme::model('rss');

$pageData['listPost']=listRss();

$pageData['setting']=$headData;

Theme::view($pageName,$pageData);


?>