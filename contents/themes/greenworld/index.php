<?php

$pageData=array();

$pageName='home';

if(Uri::isNull() || Uri::match('^home\/?'))
{
	$pageName='home';
}
elseif($matches=Uri::match('^(\w+)\/?'))
{
	$pageName=$matches[1];
}

// Theme::view('head');

Theme::controller($pageName);

// Theme::view('footer');

?>