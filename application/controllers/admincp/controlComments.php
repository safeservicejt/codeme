<?php

class controlComments
{
	public function index()
	{
       
		$post=array('alert'=>'');

		Model::load('admincp/comments');

		if($match=Uri::match('\/comments\/(\w+)'))
		{
			if(method_exists("controlComments", $match[1]))
			{	
				$method=$match[1];

				$this->$method();

				die();
			}
			
		}

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		if(Request::has('btnAction'))
		{
			actionProcess();
		}

		if(Request::has('btnSearch'))
		{
			filterProcess();
		}
		else
		{
			$post['pages']=Misc::genPage('admincp/comments',$curPage);

			$filterPending='';

			if(Uri::has('\/status\/pending'))
			{
				$filterPending=" AND c.status='0' ";
			}

			$post['theList']=Comments::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'query'=>"select c.*,p.title from post p,comments c where c.postid=p.postid order by c.commentid desc",
				'cacheTime'=>5
				));
		}

		System::setTitle('Comments list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('commentsList',$post);

		View::make('admincp/footer');

	}

	public function view()
	{
		if(!$match=Uri::match('\/view\/(\d+)'))
		{
			Redirect::to(ADMINCP_URL.'comments/');
		}


		$commentid=$match[1];

		$loadData=Comments::get(array(
			'query'=>"select p.title,c.* from post p,comments c where p.postid=c.postid AND c.commentid='$commentid'"
			));

		$post['edit']=$loadData[0];

		System::setTitle('View comment - '.ADMINCP_TITLE);


		View::make('admincp/head');

		self::makeContents('commentView',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>