<?php

class controlPages
{
	public function index()
	{

		$post=array('alert'=>'');

		Model::load('admincp/pages');

		if($match=Uri::match('\/pages\/(\w+)'))
		{
			if(method_exists("controlPages", $match[1]))
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
			$post['pages']=Misc::genPage('admincp/pages',$curPage);

			$filterPending='';


			$post['theList']=Pages::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'cacheTime'=>5
				));
		}



		System::setTitle('Pages list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('pagesList',$post);

		View::make('admincp/footer');

	}

	public function edit()
	{
		if(!$match=Uri::match('\/edit\/(\d+)'))
		{
			Redirect::to(ADMINCP_URL.'pages/');
		}


		$pageid=$match[1];

		$post=array('alert'=>'');

		if(Request::has('btnSave'))
		{
			try {
				
				updateProcess($pageid);

				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		$loadData=Pages::get(array(
			'where'=>"where pageid='$pageid'"
			));

		$post['edit']=$loadData[0];

		System::setTitle('Edit page - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('pagesEdit',$post);

		View::make('admincp/footer');		
	}
	public function addnew()
	{
		$post=array('alert'=>'');

		if(Request::has('btnAdd'))
		{
			try {
				
				insertProcess();

				$post['alert']='<div class="alert alert-success">Add new page success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}
		
		System::setTitle('Add new page - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('pagesAdd',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>