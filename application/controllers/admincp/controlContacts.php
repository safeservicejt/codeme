<?php

class controlContacts
{
	public function index()
	{
       
		$post=array('alert'=>'');

		Model::load('admincp/contacts');

		if($match=Uri::match('\/contacts\/(\w+)'))
		{
			if(method_exists("controlContacts", $match[1]))
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
			$post['pages']=Misc::genPage('admincp/contacts',$curPage);

			$filterPending='';

			if(Uri::has('\/status\/pending'))
			{
				$filterPending=" AND p.status='0' ";
			}

			$post['theList']=Contactus::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'cacheTime'=>5
				));
		}

		System::setTitle('Contacts list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('contactsList',$post);

		View::make('admincp/footer');

	}

	public function view()
	{
		if(!$match=Uri::match('\/view\/(\d+)'))
		{
			Redirect::to(ADMINCP_URL.'contacts/');
		}


		$postid=$match[1];

		$post=array('alert'=>'');

		$loadData=Contactus::get(array(
			'where'=>"where contactid='$postid'"
			));

		$post=$loadData[0];

		System::setTitle('View contact - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('contactView',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>