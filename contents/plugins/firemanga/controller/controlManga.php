<?php

// define("THIS_URL", ROOT_URL.'admincp/plugins/runc/Y29udHJvbGxlci9jb250cm9sTWFuZ2EucGhw/firemanga/');

class controlManga
{
	private static $thisPath='';
	public function index()
	{
		self::$thisPath=ROOT_PATH.'contents/plugins/firemanga/';

		$post=array('alert'=>'');

		Model::setPath(self::$thisPath.'model/');
		Model::load('manga');
		Model::resetPath();

		if($match=Uri::match('\/firemanga\/manga\/(\w+)'))
		{
			if(method_exists("controlManga", $match[1]))
			{	
				$method=$match[1];

				$this->$method();
				
			}
			
		}
		else
		{

			if(Request::has('btnAction'))
			{
				actionProcess();
			}


			$curPage=0;

			if($match=Uri::match('\/page\/(\d+)'))
			{
				$curPage=$match[1];
			}

			$theUrl=str_replace(ROOT_URL, '', THIS_URL);

			$post['pages']=Misc::genPage($theUrl,$curPage);

			if(!Request::has('btnSearch'))
			{
				$post['posts']=listPostProcess($curPage);
			}
			else
			{
				$searchData=searchProcess(Request::get('txtKeywords'));

				$post['posts']=$searchData['posts'];

				$post['pages']=$searchData['pages'];

			}		

			// $headData=array('title'=>'Manga List - FireManga');


			self::makeContent('mangaList',$post);	
			
		}


	}

	public function addnew()
	{
		$post=array('alert'=>'');

		// Model::setPath(self::$thisPath.'model/');
		// Model::load('manga');
		// Model::resetPath();


		if(Request::has('btnAdd'))
		{
			try {

				insertProcess();

				$post['alert']='<div class="alert alert-success">Success. Add new manga complete!</div>';

			} catch (Exception $e) {

				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';

			}
		}	

		self::makeContent('mangaAdd',$post);	
	}
	public function edit()
	{
		$post=array('alert'=>'');

		// Model::setPath(self::$thisPath.'model/');
		// Model::load('manga');
		// Model::resetPath();

		$id=Uri::getNext('edit');
		$post['id']=$id;

		if(Request::has('btnSave'))
		{
			try {

				updateProcess($id);

				$post['alert']='<div class="alert alert-success">Save changes successful!</div>';
				
			} catch (Exception $e) {

				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';

			}							
		}

		$loadData=editInfo($id);

		$post['edit']=$loadData['data'];

		$post['tags']=$loadData['tags'];

		$headData=array('title'=>'Edit manga - '.$loadData['data']['title'].' - FireManga');

		self::makeContent('mangaEdit',$post,$headData);	
	}

	public function makeContent($keyName='',$post=array())
	{

		// $post['headData']=$headData;

		// Render::pluginView(ROOT_PATH.'contents/plugins/firemanga/views/',$keyName,$post);	

		View::makeWithPath($keyName,$post,ROOT_PATH.'contents/plugins/firemanga/views/');	
	}

}

$run=new controlManga();

$run->index();

// controlManga::index();

?>