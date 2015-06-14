<?php

function fetchProcess()
{
	$resultData=array('error'=>'yes');

	$fetchMethod=Request::get('fetchMethod');

	$fetchCategory=base64_decode(Request::get('fetchCategory'));

	$fetchUrl=Request::get('fetchUrl');

	$sitePath=THIS_PATH.'sites/'.$fetchCategory;

	if(!file_exists($sitePath))
	{
		echo json_encode($resultData);

		die();
	}

	include($sitePath);	

	switch ($fetchMethod) {
		case 'manga':

			try {

				$run=new MangaAutoLeech();
				$run->index('manga',$fetchUrl);	

				$resultData['error']='no';
				$resultData['message']='Complete fetch data from url: '.$fetchUrl;

			} catch (Exception $e) {
				$resultData['message']='Error. '.$e->getMessage();				
			}

			echo json_encode($resultData);die();

			break;
		case 'chapter':

			try {

				$run=new MangaAutoLeech();
				$run->index('chapter',$fetchUrl);	

				$resultData['error']='no';
				$resultData['message']='Complete fetch data from url: '.$fetchUrl;

			} catch (Exception $e) {
				$resultData['message']='Error. '.$e->getMessage();				
			}

			echo json_encode($resultData);die();

			break;		
		default:
			# code...
			break;
	}

}

function listSite()
{
	$resultData=array();

	$resultData=Dir::listFiles(THIS_PATH.'sites/');

	return $resultData;
}

?>