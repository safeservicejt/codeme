<?php

// define("THIS_URL", ROOT_URL.'admincp/plugins/runc/Y29udHJvbGxlci9jb250cm9sQ2hhcHRlci5waHA=/firemanga/');

class controlChapter
{
	private static $thisPath='';
	public function index()
	{
		self::$thisPath=ROOT_PATH.'contents/plugins/firemanga/';

		$post=array('alert'=>'');

		Model::setPath(self::$thisPath.'model/');
		Model::load('chapter');
		Model::resetPath();

		if($match=Uri::match('\/firemanga\/chapter\/(\w+)'))
		{
			if(method_exists("controlChapter", $match[1]))
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

			self::makeContent('chapterList',$post);
		}		

	
	}

	public function addnew()
	{
		$post=array('alert'=>'');


		$post['id']=Uri::getNext('edit');

		if(Request::has('btnAdd'))
		{
			try {

				insertProcess();

				$post['alert']='<div class="alert alert-success">Success. Add new chapter complete!</div>';

			} catch (Exception $e) {

				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';

			}
		}	
		$headData=array('title'=>'Add new chapter - FireManga');

		self::makeContent('chapterAdd',$post,$headData);	
	}
	public function edit()
	{
		$post=array('alert'=>'');
		
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

		$headData=array('title'=>'Edit - '.$loadData['data']['manga_title'].' chapter '.$loadData['data']['number'].' - FireManga');

		self::makeContent('chapterEdit',$post,$headData);	
	}

	public function makeContent($keyName='',$post=array())
	{
		View::makeWithPath($keyName,$post,ROOT_PATH.'contents/plugins/firemanga/views/');		
	}

}

$run=new controlChapter();

$run->index();

// controlManga::index();

?>