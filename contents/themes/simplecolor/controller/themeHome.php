<?php

class themeHome
{
	public function index()
	{
		Cache::loadPage(30);

		$inputData=array();

		$curPage=0;

		Model::loadWithPath('home',System::getThemePath().'model/');

		if($match=Uri::match('page\/(\d+)'))
		{
			$curPage=(int)$match[1];
		}

		$curPage=((int)$curPage >= 0)?$curPage:0;

		$inputData['newPost']=Post::get(array(
			'limitShow'=>2,
			'limitPage'=>$curPage
			));

		if(!isset($inputData['newPost'][0]['postid']))
		{
			Redirect::to('404page');
		}

		$inputData['listPage']=Misc::genPage('',$curPage);

		self::makeContent('home',$inputData);

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