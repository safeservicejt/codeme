<?php

class themeTag
{
	public function index()
	{
		Cache::loadPage(30);
				
		$inputData=array();

		$postid=0;

		$curPage=0;
		// Model::loadWithPath('home',System::getThemePath().'model/');

		if(!$match=Uri::match('tag\/(\w+)\/?'))
		{
			Redirect::to('404page');
		}

		$friendly_url=addslashes($match[1]);

		if($match=Uri::match('page\/(\d+)'))
		{
			$curPage=(int)$match[1];
		}

		$loadData=Post::get(array(
			'limitShow'=>10,
			'limitPage'=>$curPage,
			'where'=>"where postid IN (select postid from post_tags where title='$friendly_url')",
			'orderby'=>"order by postid desc"
			));
		if(!isset($loadData[0]['postid']))
		{
			Redirect::to('404page');
		}


		$inputData['newPost']=$loadData;

		$inputData['keywords']=$friendly_url;

		$inputData['listPage']=Misc::genPage('tag/'.$friendly_url,$curPage);

		System::setTitle('Tag "'.$friendly_url.'" results:');

		self::makeContent('tag',$inputData);

		Cache::savePage();	
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