<?php

class controlPlugins
{
	public function index()
	{
      
		$post=array('alert'=>'');

		Model::load('admincp/plugins');

		if($match=Uri::match('\/plugins\/(\w+)'))
		{
			if(method_exists("controlPlugins", $match[1]))
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

		$post['theList']=Plugins::getDirs();


		View::make('admincp/head',array('title'=>'Plugin list - '.ADMINCP_TITLE));

		self::makeContents('pluginList',$post);

		View::make('admincp/footer');

	}

	public function install()
	{
		if(!$match=Uri::match('\/install\/(\w+)'))
		{
			Redirect::to(ADMINCP_URL);
		}

		$foldername=$match[1];

		Plugins::makeInstall($foldername);

		$path=PLUGINS_PATH.$foldername.'/index.php';

		if(file_exists($path))
		{
			require($path);
		}

		Redirect::to(ADMINCP_URL.'plugins');


	}

	public function controller()
	{
		if(!$match=Uri::match('\/controller\/(\w+)\/(\w+)'))
		{
			Redirect::to(ADMINCP_URL);
		}


		$foldername=$match[1];

		$funcName=$match[2];

		$path=PLUGINS_PATH.$foldername.'/controller/control'.ucfirst($funcName).'.php';

		$thisUrl=ADMINCP_URL.'plugins/controller/'.$foldername.'/'.$funcName.'/';

		if(!file_exists($path))
		{
			Redirect::to(ADMINCP_URL);
		}

		define("THIS_URL",$thisUrl);

		define("THIS_PATH",PLUGINS_PATH.$foldername.'/');
		
		$post['title']=ucfirst($foldername);

		$post['filePath']=$path;

		$post['controller']='control'.ucfirst($funcName);
		
		System::setTitle(ucfirst($foldername).' - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('pluginRunController',$post);

		View::make('admincp/footer');	
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

		$path=PLUGINS_PATH.$foldername.'/index.php';

		if(!file_exists($path))
		{
			Redirect::to(ADMINCP_URL);
		}

		define("THIS_URL",PLUGINS_URL.$foldername.'/');
		
		$post['title']=ucfirst($foldername);

		$post['filePath']=$path;

		$post['func']=$funcName;
		
		System::setTitle(ucfirst($foldername).' - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('pluginRunFunc',$post);

		View::make('admincp/footer');	
	}

	public function setting()
	{
		if(!$match=Uri::match('\/setting\/(\w+)'))
		{
			Redirect::to(ADMINCP_URL);
		}

		$foldername=$match[1];

		$path=PLUGINS_PATH.$foldername.'/setting.php';

		if(!file_exists($path))
		{
			Redirect::to(ADMINCP_URL.'plugins');
		}
		
		$post['title']=ucfirst($foldername);

		$post['filePath']=$path;

		View::make('admincp/head',array('title'=>'Setting plugin - '.ADMINCP_TITLE));

		self::makeContents('pluginSetting',$post);

		View::make('admincp/footer');	
	}

	public function uninstall()
	{
		if(!$match=Uri::match('\/uninstall\/(\w+)'))
		{
			Redirect::to(ADMINCP_URL);
		}

		$foldername=$match[1];

		Plugins::makeUninstall($foldername);

		$path=PLUGINS_PATH.$foldername.'/index.php';

		if(file_exists($path))
		{
			require($path);
		}

		PluginsZone::saveCache();

		Redirect::to(ADMINCP_URL.'plugins');

	}
	public function activate()
	{
		if(!$match=Uri::match('\/activate\/(\w+)'))
		{
			Redirect::to(ADMINCP_URL);
		}

		$foldername=$match[1];

		Database::query("update plugins set status='1' where foldername='$foldername'");
		Database::query("update plugins_meta set status='1' where foldername='$foldername'");

		PluginsZone::saveCache();
		
		Redirect::to(ADMINCP_URL.'plugins');
	}
	public function deactivate()
	{
		if(!$match=Uri::match('\/deactivate\/(\w+)'))
		{
			Redirect::to(ADMINCP_URL);
		}

		$foldername=$match[1];

		Database::query("update plugins set status='0' where foldername='$foldername'");
		Database::query("update plugins_meta set status='0' where foldername='$foldername'");

		PluginsZone::saveCache();

		Redirect::to(ADMINCP_URL.'plugins');
	}

	public function import()
	{
		$post=array('alert'=>'');

		if(Request::has('btnSend'))
		{
			try {
				
				importProcess();

				$post['alert']='<div class="alert alert-success">Import plugins success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}		
		}

		View::make('admincp/head',array('title'=>'Import plugins - '.ADMINCP_TITLE));

		self::makeContents('pluginImport',$post);

		View::make('admincp/footer');		
	}


    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>