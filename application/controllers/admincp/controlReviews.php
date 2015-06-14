<?php

class controlReviews
{
	public function index()
	{
       
		$post=array('alert'=>'');

		Model::load('admincp/reviews');

		if($match=Uri::match('\/reviews\/(\w+)'))
		{
			if(method_exists("controlReviews", $match[1]))
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
			$post['pages']=Misc::genPage('admincp/reviews',$curPage);

			$filterPending='';

			if(Uri::has('\/status\/pending'))
			{
				$filterPending=" AND r.status='pending' ";
			}

			$post['theList']=Reviews::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'query'=>"select r.*,p.title,u.username,u.email from products p,reviews r,users u where r.productid=p.productid AND r.userid=u.userid group by r.reviewid order by r.reviewid desc",
				'cacheTime'=>5
				));
		}

		System::setTitle('Reviews list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('reviewsList',$post);

		View::make('admincp/footer');

	}


    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>