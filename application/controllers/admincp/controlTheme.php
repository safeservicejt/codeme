<?php

class controlTheme
{
	public function index()
	{
      
		$post=array('alert'=>'');

		Model::load('admincp/theme');

		if($match=Uri::match('\/theme\/(\w+)'))
		{
			if(method_exists("controlTheme", $match[1]))
			{	
				$method=$match[1];

				$this->$method();

				die();
			}
			
		}

		if($match=Uri::match('\/activate\/(\w+)'))
		{
			$theName=$match[1];

			try {
				Theme::setActivate($theName);
				$post['alert']='<div class="alert alert-success">Change theme success</div>';
			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		$post['listThemes']=Theme::get();

		$post['theme']=Theme::getDefault();

		System::setTitle('Post list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('themeList',$post);

		View::make('admincp/footer');

	}



	public function filemanager()
	{

		View::make('admincp/head',array('title'=>'File Manager - '.ADMINCP_TITLE));

		self::makeContents('filemanagerMain');

		View::make('admincp/footer');		
	}
	
	public function setting()
	{
		if(!$match=Uri::match('\/setting\/(\w+)'))
		{
			Redirect::to(ADMINCP_URL);
		}

		$theName=$match[1];

		$post['title']=ucfirst($theName);

		$thePath=THEMES_PATH.$theName.'/';

		if(!is_dir($thePath))
		{
			Redirect::to(ADMINCP_URL);
		}

		$info=$thePath.'setting.php';

		if(!file_exists($info))
		{
			Redirect::to(ADMINCP_URL);
		}

		$post['filePath']=$info;


		View::make('admincp/head',array('title'=>'Setting theme - '.ADMINCP_TITLE));

		self::makeContents('themeSetting',$post);

		View::make('admincp/footer');		
	}

	public function import()
	{
		$post=array('alert'=>'');

		if(Request::has('btnSend'))
		{
			try {
				
				importProcess();

				$post['alert']='<div class="alert alert-success">Import theme success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}		
		}

		View::make('admincp/head',array('title'=>'Import theme - '.ADMINCP_TITLE));

		self::makeContents('themeImport',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>