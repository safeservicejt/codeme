<?php

class controlDashboard
{
	public function index()
	{

		Model::load('admincp/dashboard');

		$post=countStats();

		// $headData=array('title'=>'Dashboard - '.ADMINCP_TITLE);

		System::setTitle('Dashboard - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('dashboard',$post);

		View::make('admincp/footer');


	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>