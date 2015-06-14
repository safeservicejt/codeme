<?php

class themePost
{
	public function index()
	{
		$inputData=array();

		$postid=0;

		Model::loadWithPath('post',System::getThemePath().'model/');

		if(!$match=Uri::match('post\/(.*?)\.html$'))
		{
			Redirect::to('404page');
		}

		$friendly_url=addslashes($match[1]);

		$loadData=Post::get(array(
			'where'=>"where friendly_url='$friendly_url'"
			));

		if(!isset($loadData[0]['postid']))
		{
			Redirect::to('404page');
		}

		$inputData=$loadData[0];

		if(Request::has('btnComment'))
		{
			try {
				sendComment($loadData[0]['postid']);
				$inputData['commentAlert']='<div class="alert alert-success">Send comment success.</div>';
			} catch (Exception $e) {
				$inputData['commentAlert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}


		$postid=$loadData[0]['postid'];

		$listTag=PostTags::renderToLink($postid);

		$inputData['listTag']=$listTag;

		$inputData['listComments']=Comments::get(array(
			'where'=>"where postid='$postid' AND status='1'",
			'orderby'=>"order by postid desc"
			));

		Post::upView($postid);

		System::setTitle(ucfirst($loadData[0]['title']));

		self::makeContent('post',$inputData);
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