<?php

class controlPaymentmethods
{
	public function index()
	{
      
		$post=array('alert'=>'');

		Model::load('admincp/paymentmethods');

		if($match=Uri::match('\/paymentmethods\/(\w+)'))
		{
			if(method_exists("controlPaymentmethods", $match[1]))
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

		$post['theList']=Paymentmethods::getDirs();

		System::setTitle('Paymentmethods list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('paymentmethodsList',$post);

		View::make('admincp/footer');

	}

	public function install()
	{
		if(!$match=Uri::match('\/install\/(\w+)'))
		{
			Redirect::to(ADMINCP_URL);
		}

		$foldername=$match[1];

		Paymentmethods::makeInstall($foldername);

		$path=PAYMENTMETHODS_PATH.$foldername.'/index.php';

		if(file_exists($path))
		{
			require($path);

			$foldername=ucfirst($foldername);

			if(method_exists($foldername, 'install'))
			{
				$foldername::install();
			}
			
		}

		Redirect::to(ADMINCP_URL.'paymentmethods');


	}

	public function run()
	{
		if(!$match=Uri::match('\/run\/(\w+)'))
		{
			Redirect::to(ADMINCP_URL);
		}



		$funcName=base64_decode($match[1]);

		$parse=explode(':', $funcName);

		$foldername=$parse[0];

		$funcName=$parse[1];

		$path=PAYMENTMETHODS_PATH.$foldername.'/index.php';

		if(!file_exists($path))
		{
			Redirect::to(ADMINCP_URL);
		}
		
		$post['title']=ucfirst($foldername);

		$post['filePath']=$path;

		$post['func']=$funcName;

		View::make('admincp/head',array('title'=>ucfirst($foldername).' - '.ADMINCP_TITLE));

		self::makeContents('paymentmethodRunFunc',$post);

		View::make('admincp/footer');	
	}

	public function setting()
	{
		if(!$match=Uri::match('\/setting\/(\w+)'))
		{
			Redirect::to(ADMINCP_URL);
		}

		$foldername=$match[1];

		$path=PAYMENTMETHODS_PATH.$foldername.'/setting.php';

		if(!file_exists($path))
		{
			Redirect::to(ADMINCP_URL.'plugins');
		}
		
		$post['title']=ucfirst($foldername);

		$post['filePath']=$path;

		View::make('admincp/head',array('title'=>'Setting payment method - '.ADMINCP_TITLE));

		self::makeContents('paymentmethodSetting',$post);

		View::make('admincp/footer');	
	}

	public function uninstall()
	{
		if(!$match=Uri::match('\/uninstall\/(\w+)'))
		{
			Redirect::to(ADMINCP_URL);
		}

		$foldername=$match[1];

		Paymentmethods::makeUninstall($foldername);

		$path=PAYMENTMETHODS_PATH.$foldername.'/index.php';

		if(file_exists($path))
		{
			require($path);

			$foldername=ucfirst($foldername);

			if(method_exists($foldername, 'uninstall'))
			{
				$foldername::uninstall();
			}
		}

		Paymentmethods::saveCache();

		Redirect::to(ADMINCP_URL.'paymentmethods');

	}
	public function activate()
	{
		if(!$match=Uri::match('\/activate\/(\w+)'))
		{
			Redirect::to(ADMINCP_URL);
		}

		$foldername=$match[1];

		Database::query("update payment_methods set status='1' where foldername='$foldername'");

		Paymentmethods::saveCache();
		
		Redirect::to(ADMINCP_URL.'paymentmethods');
	}
	public function deactivate()
	{
		if(!$match=Uri::match('\/deactivate\/(\w+)'))
		{
			Redirect::to(ADMINCP_URL);
		}

		$foldername=$match[1];

		Database::query("update payment_methods set status='0' where foldername='$foldername'");

		Paymentmethods::saveCache();

		Redirect::to(ADMINCP_URL.'paymentmethods');
	}

	public function import()
	{
		$post=array('alert'=>'');

		if(Request::has('btnSend'))
		{
			try {
				
				Paymentmethods::import();

				$post['alert']='<div class="alert alert-success">Import payment method success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}		
		}

		View::make('admincp/head',array('title'=>'Import payment method - '.ADMINCP_TITLE));

		self::makeContents('paymentmethodImport',$post);

		View::make('admincp/footer');		
	}


    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>