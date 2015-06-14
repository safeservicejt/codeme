<?php

class controlSetting
{
	public function index()
	{
		
		$post=array('alert'=>'');

		// Model::load('admincp/setting');

		if($match=Uri::match('\/setting\/(\w+)'))
		{
			if(method_exists("controlSetting", $match[1]))
			{	
				$method=$match[1];

				$this->$method();

				die();
			}
			
		}

		if(Request::has('btnSave'))
		{
			System::saveSetting(Request::get('general'));
		}

		if(!$data=System::getSetting())
		{
			$data=System::makeSetting();
		}


		$post=$data;

		$post['usergroups']=UserGroups::get();
		
		System::setTitle('Setting System - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('settingGeneral',$post);

		View::make('admincp/footer');

	}
	public function mailsystem()
	{
		$post=array('alert'=>'');

		if(Request::has('btnSave'))
		{
			System::saveMailSetting(Request::get('mail'));
		}


		if(!$data=System::getSetting())
		{
			$data=System::makeSetting();
		}

		$post=$data;

		View::make('admincp/head',array('title'=>'Mail Setting - '.ADMINCP_TITLE));

		self::makeContents('settingMail',$post);

		View::make('admincp/footer');		
	}
	public function ecommerce()
	{
		$post=array('alert'=>'');
		if(Request::has('btnSave'))

		{
			System::saveSetting(Request::get('general'));
		}
		

		if(!$data=System::getSetting())
		{
			$data=System::makeSetting();
		}

		$post=$data;

		$loadData=Currency::get();

		$post['listCurrency']=$loadData;

		View::make('admincp/head',array('title'=>'Ecommerce Setting - '.ADMINCP_TITLE));

		self::makeContents('settingEcommerce',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>