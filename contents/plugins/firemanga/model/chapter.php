<?php

function editInfo($id)
{
	$resultData=array();

	$postData=MangaChapters::get(array(
		'isHook'=>'no',
		'query'=>"select mc.*,ml.title as manga_title from chapter_list mc, manga_list ml where mc.chapterid='$id' AND mc.mangaid=ml.mangaid"
		));	

	$resultData['data']=$postData[0];

	return $resultData;
}

function actionProcess()
{
	$action=Request::get('action');

	$id=Request::get('id');

	if((int)$id <= 0)
	{
		return false;
	}

	$listID="'".implode("','",$id)."'";

	switch ($action) {
		case 'delete':
			MangaChapters::remove($id);
			break;

		case 'publish':
			MangaChapters::update($id,array(
				'status'=>1
				),"chapterid IN ($listID)");
			break;
		case 'unpublish':
			MangaChapters::update($id,array(
				'status'=>0
				),"chapterid IN ($listID)");
			break;
		case 'setFeatured':
			MangaChapters::update($id,array(
				'is_featured'=>1,
				'featured_date'=>date('Y-m-d h:i:s')
				),"chapterid IN ($listID)");
			break;
		case 'unsetFeatured':
			MangaChapters::update($id,array(
				'is_featured'=>0
				),"chapterid IN ($listID)");
			break;		
	}
}

function updateProcess($id)
{

	$valid=Validator::make(array(
		'send.title'=>'slashes',
		'send.number'=>'slashes',
		'send.content_type'=>'slashes',
		'send.mangaid'=>'slashes',
		'send.content'=>'slashes',
		'uploadIMGMethod'=>'slashes',
		'urlThumbnail'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error. Edit chapter error!");
		
	}

	// print_r(Request::get('tags'));die();

	$uploadIMGMethod=Request::get('uploadIMGMethod');

	$uploadFileMethod=Request::get('uploadFileMethod');

	$data=Request::get('send');

	if((int)$data['mangaid']==0)
	{
		throw new Exception("Error. You must choose a manga.");
	}

	if((int)$data['number'] > 0)
	{
		$getData=MangaChapters::get(array(
			'where'=>"where mangaid='".$data['mangaid']."' AND number='".$data['number']."' AND chapterid<>'$id'"
			));

		if(isset($getData[0]['chapterid']))
		{
			throw new Exception("Error. This chapter number exists in database!");
		}
	}
	
	MangaChapters::update($id,$data);
}

function insertProcess()
{

	$valid=Validator::make(array(
		'send.title'=>'slashes',
		'send.number'=>'slashes',
		'send.content_type'=>'slashes',
		'send.mangaid'=>'slashes',
		'send.content'=>'slashes',
		'uploadIMGMethod'=>'slashes',
		'urlThumbnail'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error. Add new chapter error!");
		
	}

	// print_r(Request::get('tags'));die();

	$uploadIMGMethod=Request::get('uploadIMGMethod');

	$uploadFileMethod=Request::get('uploadFileMethod');

	$data=Request::get('send');

	if((int)$data['mangaid']==0)
	{
		throw new Exception("Error. You must choose a manga.");
	}

	if((int)$data['number'] > 0)
	{
		$getData=MangaChapters::get(array(
			'where'=>"where mangaid='".$data['mangaid']."' AND number='".$data['number']."'"
			));

		if(isset($getData[0]['chapterid']))
		{
			throw new Exception("Error. This chapter number exists in database!");
		}
	}

	$resultIMG=array();

	switch ($uploadIMGMethod) {
		case 'frompc':

			if(preg_match('/.*?\.\w+/i', $_FILES['listimg']['name'][0]))
			{
				if(!$resultIMG=File::uploadMultiple('listimg','uploads/images/'))
				{
					throw new Exception("Error. Upload image error!");
				}				
			}
			else
			{
				throw new Exception("Error. You must choose chapter's images from your pc.");
			}

			break;

		case 'fromurl':

			if(!isset($data['content'][5]))
			{
				throw new Exception("Error. Type image url into text box.");
			}

			if($data['content_type']=='host')
			{
				$parse=explode("\r\n", $data['content']);

				$totalIMG=count($parse);

				$countIMG=0;

				for ($j=0; $j < $totalIMG; $j++) { 

					if(preg_match('/http/i', trim($parse[$j])))
					{
						if($shortPath=File::uploadFromUrl(trim($parse[$j]),'uploads/images/'))
						{
							$resultIMG[$countIMG]=$shortPath;

							$countIMG++;
						}
					}

				}

			}

			break;
	}


	if($data['content_type']=='host')
	{
		if(isset($resultIMG[0][5]))
		{
			$listIMG=implode("\r\n", $resultIMG);

			$data['content']=$listIMG;			
		}

	}


	if(!$id=MangaChapters::insert($data))
	{
		throw new Exception("Error. ".Database::$error);
	}	

}


function listPostProcess($curPage)
{
	$queryData=array(
			'limitShow'=>20,			
			'limitPage'=>$curPage,
			'isHook'=>'no',
			'query'=>"select mc.*,ml.title as manga_title from chapter_list mc,manga_list ml where mc.mangaid=ml.mangaid order by mc.date_added desc"
			);

	$getData=MangaChapters::get($queryData);

	return $getData;
}


function searchProcess($txtKeyword,$fromPage=-1)
{

	$curPage=($fromPage >= 0)?$fromPage:Uri::getNext('news');

	if($curPage=='page' || $fromPage >= 0)
	{
		$curPage=($fromPage >= 0)?$fromPage:Uri::getNext('page');
	}
	else
	{
		$curPage=0;
	}

	$resultData=array();

	$theUrl=str_replace(ROOT_URL, '', THIS_URL);

	$resultData['pages']=Misc::genPage($theUrl,$curPage);	

	$txtKeyword=trim($txtKeyword);

	Request::make('txtKeyword',$txtKeyword);

	$valid=Validator::make(array(
		'txtKeyword'=>'min:1|slashes'
		));

	if(!$valid)
	{
		$resultData['posts']='';

		$resultData['pages']='';

		return $resultData;
	}

	if(preg_match('/^(\w+)\:(.*?)$/i', $txtKeyword,$matches))
	{
		$method=strtolower($matches[1]);

		$keyword=strtolower(trim($matches[2]));

		$method=($method=='mangaid')?'id':$method;
		$method=($method=='cat')?'category':$method;

		switch ($method) {
			case 'id':
			$resultData['posts']=Manga::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where status='1' AND mangaid='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'category':
			$resultData['posts']=Manga::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where status='1' AND catid='$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'before':
			$resultData['posts']=Manga::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where status='1' AND date_added < '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'after':
			$resultData['posts']=Manga::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where status='1' AND date_added > '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;
			case 'on':
			$resultData['posts']=Manga::get(array(
				'limitShow'=>20,			
				'limitPage'=>$curPage,
				'where'=>"where status='1' AND date_added = '$keyword'",
				'orderby'=>'order by date_added desc',
				'isHook'=>'no'
				));
				break;


		}
		// print_r($matches);die();
	}
	else
	{
		// echo $txtKeyword;die();
		$txtKeyword=String::encode($txtKeyword);

		$resultData['posts']=Manga::get(array(
			'limitShow'=>20,			
			'limitPage'=>$curPage,
			'where'=>"where status='1' AND title LIKE '%$txtKeyword%'",
			'orderby'=>'order by date_added desc',
			'isHook'=>'no'
			));	
	}

	return $resultData;
}


?>