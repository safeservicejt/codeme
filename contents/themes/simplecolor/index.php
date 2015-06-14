<?php

$pageData=array();

$pageName='home';


if(Uri::isNull())
{
	$pageName='home';
}

if($matches=Uri::match('^(\w+)\/?'))
{
	$pageName=$matches[1];
}

if($matches=Uri::match('^page\/?'))
{
	$pageName='home';
}

// Theme::view('head');

Controller::loadWithPath('theme'.ucfirst($pageName),'index',System::getThemePath().'controller/');

// Theme::view('footer');

?>