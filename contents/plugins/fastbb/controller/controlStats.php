<?php

// define("THIS_URL", ROOT_URL.'admincp/plugins/runc/Y29udHJvbGxlci9jb250cm9sQ2hhcHRlci5waHA=/firemanga/');

class controlStats
{
	private static $thisPath='';
	public function index()
	{
		self::$thisPath=ROOT_PATH.'contents/plugins/firemanga/';

		$post=array('alert'=>'');

		Model::setPath(self::$thisPath.'model/');
		Model::load('stats');
		Model::resetPath();

		$post=summary();

		$headData=array('title'=>'Dashboard - FireManga');

		self::makeContent('statsView',$post,$headData);	
	}

	public function makeContent($keyName='',$post=array(),$headData=array())
	{
		$post['headData']=$headData;

		Render::pluginView(ROOT_PATH.'contents/plugins/firemanga/views/',$keyName,$post);		
	}

}

$run=new controlStats();

$run->index();

// controlManga::index();

?>