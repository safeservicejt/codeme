<?php

class themeContactus
{
	public function index()
	{
		Cache::loadPage(30);

		$inputData=array('alert'=>'');

		Model::loadWithPath('contactus',System::getThemePath().'model/');

		if(Request::has('btnSend'))
		{
			try {
				contactProcess();
				$inputData['alert']='<div class="alert alert-success">Send contact success.</div>';
			} catch (Exception $e) {
				$inputData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		System::setTitle('Contact us');

		self::makeContent('contactus',$inputData);
		
		Cache::savePage();		
	}

	public function makeContent($viewName,$inputData=array())
	{
		$themePath=System::getThemePath().'view/';

		$inputData['themePath']=$themePath;

		View::makeWithPath('head',array(),$themePath);

		View::makeWithPath($viewName,$inputData,$themePath);

		View::makeWithPath('footer',array(),$themePath);

	}


}

?>