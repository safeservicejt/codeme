<?php

// define("THIS_URL", ROOT_URL.'admincp/plugins/runc/Y29udHJvbGxlci9jb250cm9sQ2hhcHRlci5waHA=/firemanga/');

class controlLeech
{
	private static $thisPath='';
	public function index()
	{
		self::$thisPath=ROOT_PATH.'contents/plugins/firemanga/';
        
		$post=array('alert'=>'');

		Model::setPath(self::$thisPath.'model/');
		Model::load('leech');
		Model::resetPath();

		if($match=Uri::match('\/firemanga\/leech\/(\w+)'))
		{
			if(method_exists("controlLeech", $match[1]))
			{	
				$method=$match[1];

				$this->$method();
				
			}
			
		}
		else
		{
			if(Uri::has('\/process'))
			{
				$this->process();
				die();
			}

			$post['listSite']=listSite();

			// print_r($post);die();

			self::makeContent('leechView',$post);	
		}


	}

	public function process()
	{
		fetchProcess();
	}

	public function makeContent($keyName='',$post=array())
	{
		View::makeWithPath($keyName,$post,ROOT_PATH.'contents/plugins/firemanga/views/');	
				
	}

}

$run=new controlLeech();

$run->index();

// controlManga::index();

?>