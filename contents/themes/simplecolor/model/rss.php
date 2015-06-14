<?php

function listRss()
{
	header("Content-Type: application/xml; charset=UTF-8");

	$location=Url::rss();

	if($match=Uri::match('^(.*?)$'))
	{
		$location=ROOT_URL.$match[1];

		$reLocation=base64_encode($location);

		if($loadData=Cache::loadKey($reLocation,60))
		{
			$loadData=json_decode($loadData,true);

			return $loadData;
		}

	}

	$inputData=array(
		'limitShow'=>15,
		'limitPage'=>0
		);


	if($match=Uri::match('\/page\/(\d+)'))
	{
		$inputData['limitPage']=$match[1];
	}
	if($match=Uri::match('\/category\/(\d+)'))
	{
		$id=$match[1];
		$inputData['where']="where catid='$id'";
	}

	if($match=Uri::match('rss\/products'))
	{
		$loadData=Products::get($inputData);
	}
	else
	{
		$loadData=Post::get($inputData);
	}

	$reLocation=base64_encode($location);

	Cache::saveKey($reLocation,json_encode($loadData));

	return $loadData;
}

?>