<?php

// define("THIS_URL", ROOT_URL.'admincp/plugins/runc/Y29udHJvbGxlci9jb250cm9sQ2hhcHRlci5waHA=/firemanga/');

class controlLeech
{
	private static $thisPath='';
	public function index()
	{
		self::$thisPath=ROOT_PATH.'contents/plugins/firemanga/';

        if($match=Uri::match('\/jsonManga'))
        {
            $keyword=String::encode(Request::get('keyword',''));

            $loadData=Manga::get(array(
            	'where'=>"where title LIKE '%$keyword%'",
                'orderby'=>'order by title asc'
                ));

            $total=count($loadData);

            $li='';

            for($i=0;$i<$total;$i++)
            {
                $li.='<li><span data-method="manga" data-id="'.$loadData[$i]['mangaid'].'" >'.$loadData[$i]['title'].'</span></li>';
            }

            echo $li;
            die();
        }
        
		$post=array('alert'=>'');

		Model::setPath(self::$thisPath.'model/');
		Model::load('leech');
		Model::resetPath();
		
		if(Uri::has('\/process'))
		{
			$this->process();
			die();
		}

		$post['listSite']=listSite();

		// print_r($post);die();

		$headData=array('title'=>'Auto Fetch - FireManga');

		self::makeContent('leechView',$post,$headData);	
	}

	public function process()
	{
		fetchProcess();
	}

	public function makeContent($keyName='',$post=array(),$headData=array())
	{
		$post['headData']=$headData;

		Render::pluginView(ROOT_PATH.'contents/plugins/firemanga/views/',$keyName,$post);		
	}

}

$run=new controlLeech();

$run->index();

// controlManga::index();

?>