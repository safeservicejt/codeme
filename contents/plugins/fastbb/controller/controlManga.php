<?php

// define("THIS_URL", ROOT_URL.'admincp/plugins/runc/Y29udHJvbGxlci9jb250cm9sTWFuZ2EucGhw/firemanga/');

class controlManga
{
	private static $thisPath='';
	public function index()
	{
		self::$thisPath=ROOT_PATH.'contents/plugins/firemanga/';

		if(Uri::has('\/edit'))
		{
			$this->edit();
			die();
		}

		if(Uri::has('\/addnew'))
		{
			$this->addnew();
			die();
		}
        if($match=Uri::match('\/jsonCategory'))
        {
            $keyword=String::encode(Request::get('keyword',''));

            $loadData=Categories::get(array(
            	'where'=>"where cattitle LIKE '%$keyword%'",
                'orderby'=>'order by cattitle asc'
                ));

            $total=count($loadData);

            $li='';

            for($i=0;$i<$total;$i++)
            {
                $li.='<li><span data-method="category" data-id="'.$loadData[$i]['catid'].'" >'.$loadData[$i]['cattitle'].'</span></li>';
            }

            echo $li;
            die();
        }
        if($match=Uri::match('\/jsonAuthor'))
        {
            $keyword=String::encode(Request::get('keyword',''));

            $loadData=MangaAuthors::get(array(
            	'where'=>"where title LIKE '%$keyword%'",
                'orderby'=>'order by title asc'
                ));

            $total=count($loadData);

            $li='';

            for($i=0;$i<$total;$i++)
            {
                $li.='<li><span data-method="author" data-id="'.$loadData[$i]['authorid'].'" >'.$loadData[$i]['title'].'</span></li>';
            }

            echo $li;
            die();
        }

		$post=array('alert'=>'');

		Model::setPath(self::$thisPath.'model/');
		Model::load('manga');
		Model::resetPath();

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

		$headData=array('title'=>'Manga List - FireManga');

		self::makeContent('mangaList',$post,$headData);	
	}

	public function addnew()
	{
		$post=array('alert'=>'');

		Model::setPath(self::$thisPath.'model/');
		Model::load('manga');
		Model::resetPath();

		$post['id']=Uri::getNext('edit');

		if(Request::has('btnAdd'))
		{
			try {

				insertProcess();

				$post['alert']='<div class="alert alert-success">Success. Add new manga complete!</div>';

			} catch (Exception $e) {

				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';

			}
		}	
		$headData=array('title'=>'Add new manga - FireManga');

		self::makeContent('mangaAdd',$post,$headData);	
	}
	public function edit()
	{
		$post=array('alert'=>'');

		Model::setPath(self::$thisPath.'model/');
		Model::load('manga');
		Model::resetPath();

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

	public function makeContent($keyName='',$post=array(),$headData=array())
	{

		$post['headData']=$headData;

		Render::pluginView(ROOT_PATH.'contents/plugins/firemanga/views/',$keyName,$post);		
	}

}

$run=new controlManga();

$run->index();

// controlManga::index();

?>