<?php

class controlUserGroups
{
	public function index()
	{
		
		$post=array('alert'=>'');

		Model::load('admincp/usergroups');

		if($match=Uri::match('\/usergroups\/(\w+)'))
		{
			if(method_exists("controlUserGroups", $match[1]))
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

		// $valid=UserGroups::getThisPermission('can_addnew_usergroup');


		$post['pages']=Misc::genPage('admincp/usergroups',$curPage);

		$post['theList']=UserGroups::get(array(
			'limitShow'=>20,
			'limitPage'=>$curPage
			));
		
		System::setTitle('Usergroups list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('usergroupsList',$post);

		View::make('admincp/footer');

	}

	public function edit()
	{
		if(!$match=Uri::match('\/edit\/(\d+)'))
		{
			Redirect::to(ADMINCP_URL.'usergroups/');
		}


		$groupid=$match[1];

		$post=array('alert'=>'');

		if(Request::has('btnSave'))
		{
			try {
				
				updateProcess($groupid);

				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		$loadData=UserGroups::get(array(
			'where'=>"where groupid='$groupid'"
			));

		$post['edit']=$loadData[0];

		System::setTitle('Edit group - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('usergroupsEdit',$post);

		View::make('admincp/footer');		
	}
	public function addnew()
	{
		$post=array('alert'=>'');

		if(Request::has('btnAdd'))
		{
			try {
				
				insertProcess();

				$post['alert']='<div class="alert alert-success">Add new user group success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		System::setTitle('Add new usergroup - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('usergroupsAdd',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>