<?php

function editInfo($id)
{
	$resultData=array();

	$postData=Manga::get(array(
		'isHook'=>'no',
		'query'=>"select ml.*,ma.title as author_title from manga_list ml, manga_authors ma where ml.authorid=ma.authorid AND ml.mangaid='$id'"
		));	

	$loadCat=Categories::get(array(
		'isHook'=>'no',
		'query'=>"select c.cattitle,c.catid from categories c,manga_categories mc where mc.catid=c.catid AND mc.mangaid='$id'"
		));
	
	if(isset($loadCat[0]['cattitle']))
	$postData[0]['listCat']=$loadCat;


	$resultData['data']=$postData[0];

	$listTags=MangaTags::render(array(
		'where'=>"where mangaid='$id'"
		));	

	$resultData['tags']=$listTags;

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
			Manga::remove($id);
			break;

		case 'publish':
			Manga::update($listID,array(
				'status'=>1
				),"mangaid IN ($listID)");
			break;
		case 'unpublish':
			Manga::update($listID,array(
				'status'=>0
				),"mangaid IN ($listID)");
			break;
		case 'setFeatured':
			Manga::update($listID,array(
				'is_featured'=>1,
				'featured_date'=>date('Y-m-d h:i:s')
				),"mangaid IN ($listID)");
			break;
		case 'unsetFeatured':
			Manga::update($listID,array(
				'is_featured'=>0
				),"mangaid IN ($listID)");
			break;
		case 'completed':
			Manga::update($listID,array(
				'compeleted'=>1
				),"mangaid IN ($listID)");
			break;
		case 'uncomplete':
			Manga::update($listID,array(
				'compeleted'=>0
				),"mangaid IN ($listID)");
			break;
		
	}
}

function updateProcess($id)
{
	$alert='<div class="alert alert-warning">Error. Edit manga error!</div>';

	$valid=Validator::make(array(
		'send.title'=>'min:3|slashes',
		'send.keywords'=>'slashes',
		'tags'=>'slashes',
		'authorid'=>'slashes',
		'send.preview_url'=>'slashes',
		'uploadIMGMethod'=>'slashes',
		'urlThumbnail'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error. Edit manga error");
		
	}

	// print_r(Request::get('tags'));die();

	$uploadIMGMethod=Request::get('uploadIMGMethod');

	$uploadFileMethod=Request::get('uploadFileMethod');

	$data=Request::get('send');

	$catid=Request::get('catid');

	$data['authorid']=Request::get('authorid','0');

	$data['friendly_url']=Url::makeFriendly($data['title']);

	$authorName=trim(Request::get('author_name'));

	if(isset($authorName[2]) && (int)$data['authorid']==0)
	{

		$valid=Validator::make(array(
			'author_name'=>'slashes'
			));

		$getData=MangaAuthors::get(array(
			'where'=>"where title LIKE '$authorName'"
			));

		if(!isset($getData[0]['title']))
		{
			if(!$id=MangaAuthors::insert(array('title'=>$authorName)))
			{
				throw new Exception("Error while trying to insert new author.");
				
			}

			$data['authorid']=$id;				
		}
		else
		{
			$data['authorid']=$getData[0]['authorid'];
		}

	}

	if(!Manga::update($id,$data))
	{
		throw new Exception("Save change error. ".Database::$error);
	}


	$previewImg='';

	$loadData=Manga::get(array(
		'where'=>"where mangaid='$id'"
		));

	switch ($uploadIMGMethod) {
		case 'frompc':

			if(preg_match('/.*?\.\w+/i', $_FILES['pcThumbnail']['name']))
			{
				if(!$previewImg=File::upload('pcThumbnail','uploads/images/'))
				{
					throw new Exception("Error. Upload image error!");
					
				}
			}

			break;

		case 'fromurl':

			$imgUrl=Request::get('urlThumbnail','');

			if(isset($imgUrl[4]))
			{
				if(!$previewImg=File::uploadFromUrl($imgUrl,'uploads/images/'))
				{
					throw new Exception("Error. Upload image error!");
				}				
			}

			break;
	}

	$updateData=array();

	if(isset($previewImg[4]))
	{
		$filePath=ROOT_PATH.$loadData[0]['image'];

		if(file_exists($filePath))
		{
			unlink($filePath);

			$filePath=dirname($filePath);

			rmdir($filePath);
		}

		$updateData['image']=$previewImg;	
		
		Manga::update($id,$updateData);			
	}

	MangaTags::remove(array($id));

	MangaCategories::remove(array($id));

	Manga::insertTags($id,Request::get('tags'));	

	$totalCat=count($catid);

	if(isset($catid[0]) && (int)$catid[0] > 0)
	for ($i=0; $i < $totalCat; $i++) { 
		$insertData=array(
			'catid'=>$catid[$i],
			'mangaid'=>$id
			);	

		MangaCategories::insert($insertData);
	}


}

function insertProcess()
{

	$valid=Validator::make(array(
		'send.title'=>'min:3|slashes',
		'send.keywords'=>'slashes',
		'tags'=>'slashes',
		'authorid'=>'slashes',
		'send.preview_url'=>'slashes',
		'uploadIMGMethod'=>'slashes',
		'urlThumbnail'=>'slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error. Add new manga error!");
		
	}

	$getData=Manga::get(array(
		'where'=>"where title LIKE '".trim(Request::get('send.title'))."'"
		));

	if(isset($getData[0]['title']))
	{
		throw new Exception("This manga have been exists in database !");
	}

	// print_r(Request::get('tags'));die();

	$uploadIMGMethod=Request::get('uploadIMGMethod');

	$uploadFileMethod=Request::get('uploadFileMethod');

	$data=Request::get('send');

	$catid=Request::get('catid');

	$data['authorid']=Request::get('authorid','0');

	if((int)$data['authorid']==0)
	{
		$authorName=trim(Request::get('author_name'));

		if(isset($authorName[2]))
		{

			$valid=Validator::make(array(
				'author_name'=>'slashes'
				));

			$getData=MangaAuthors::get(array(
				'where'=>"where title LIKE '$authorName'"
				));

			if(!isset($getData[0]['title']))
			{
				if(!$id=MangaAuthors::insert(array('title'=>$authorName)))
				{
					throw new Exception("Error while trying to insert new author.");
					
				}

				$data['authorid']=$id;				
			}
			else
			{
				$data['authorid']=$getData[0]['authorid'];
			}

		}
	}

	if(!$id=Manga::insert($data))
	{
		throw new Exception("Error. ".Database::$error);
	}

	$previewImg='';

	switch ($uploadIMGMethod) {
		case 'frompc':

			if(preg_match('/.*?\.\w+/i', $_FILES['pcThumbnail']['name']))
			{
				if(!$previewImg=File::upload('pcThumbnail','uploads/images/'))
				{
					throw new Exception("Error. Upload image error!");
				}				
			}

			break;

		case 'fromurl':

			$imgUrl=Request::get('urlThumbnail','');

			if(isset($imgUrl[4]))
			{
				if(!$previewImg=File::uploadFromUrl($imgUrl,'uploads/images/'))
				{
					throw new Exception("Error. Upload image error!");
				}				
			}

			break;
	}

	if(isset($previewImg[3]))
	{
		$updateData=array();

		$updateData['image']=$previewImg;

		Manga::update($id,$updateData);		
	}

	Manga::insertTags($id,Request::get('tags'));	

	$totalCat=count($catid);

	if(isset($catid[0]) && (int)$catid[0] > 0)
	for ($i=0; $i < $totalCat; $i++) { 
		$insertData=array(
			'catid'=>$catid[$i],
			'mangaid'=>$id
			);	

		MangaCategories::insert($insertData);
	}

}


function listPostProcess($curPage)
{
	$queryData=array(
			'limitShow'=>20,			
			'limitPage'=>$curPage,
			'isHook'=>'no',
			'where'=>"where status='1'"
			);

	$getData=Manga::get($queryData);

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