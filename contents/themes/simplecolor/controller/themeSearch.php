<?php

class themeSearch
{
	public function index()
	{
		$inputData=array();

		$postid=0;

		$curPage=0;
		// Model::loadWithPath('home',System::getThemePath().'model/');


		if($match=Uri::match('page\/(\d+)'))
		{
			$curPage=(int)$match[1];
		}

		$txtKeywords=addslashes(Request::get('txtKeywords',''));

		if($match=Uri::match('\/keyword\/(.*?)\/page'))
		{
			$txtKeywords=base64_decode($match[1]);
		}

		$loadData=Post::get(array(
			'limitShow'=>10,
			'limitPage'=>$curPage,
			'where'=>"where title LIKE '%$txtKeywords%'",
			'orderby'=>"order by postid desc"
			));
		if(!isset($loadData[0]['postid']))
		{
			Redirect::to('404page');
		}


		$inputData['newPost']=$loadData;

		$inputData['keywords']=$txtKeywords;

		$inputData['listPage']=Misc::genPage('search/keyword/'.base64_encode($txtKeywords),$curPage);

		System::setTitle('Search result with keyword "'.$txtKeywords.'" results:');

		self::makeContent('search',$inputData);
	}

	public function makeContent($viewName,$inputData=array())
	{
		$themePath=System::getThemePath().'view/';

		$inputData['themePath']=$themePath;

		View::makeWithPath('head',array(),$themePath);

		View::makeWithPath($viewName,$inputData,$themePath);

		View::makeWithPath('footer',array(),$themePath);

	}


}

?>