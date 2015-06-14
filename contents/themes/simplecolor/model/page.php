<?php

function pageProcess($inputData)
{
	$match=Uri::match('^page-(\d+)-(.*?)\.html');

	if(!$match)
	{
		Redirect::to('404page');
		// Alert::make('Page not found');
	}

	$id=$match[1];

	$friendly_url=$match[2];

	$loadData=Pages::get(array(
		'where'=>"where pageid='$id' AND friendly_url='$friendly_url' AND status='1'"
		));

	if(!isset($loadData[0]['title']))
	{
		Redirect::to('404page');
		// Alert::make('Page not found');
	}

	$inputData['title']=$loadData[0]['title'];
	
	$inputData['content']=$loadData[0]['content'];

	$inputData['page_type']=$loadData[0]['page_type'];

	if(strlen($loadData[0]['keywords']) > 5)
	$inputData['keywords']=$loadData[0]['keywords'];

	return $inputData;

}

?>