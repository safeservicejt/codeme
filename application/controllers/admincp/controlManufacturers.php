<?php

class controlManufacturers
{
	public function index()
	{
		
		$post=array('alert'=>'');

		Model::load('admincp/manufacturers');
		
		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		if(Request::has('btnAction'))
		{
			actionProcess();
		}

		if(Request::has('btnAdd'))
		{
			try {
				
				insertProcess();

				$post['alert']='<div class="alert alert-success">Add new manufacturer success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnSave'))
		{
			$match=Uri::match('\/edit\/(\d+)');

			try {
				
				updateProcess($match[1]);

				$post['alert']='<div class="alert alert-success">Update manufacturers success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnSearch'))
		{
			filterProcess();
		}
		else
		{
			$post['pages']=Misc::genPage('admincp/manufacturers',$curPage);

			$post['theList']=Manufacturers::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'orderby'=>'order by mid desc',
				'cacheTime'=>5
				));
		}

		if($match=Uri::match('\/edit\/(\d+)'))
		{
			$loadData=Manufacturers::get(array(
				'where'=>"where mid='".$match[1]."'"
				));

			$post['edit']=$loadData[0];
		}
		
		System::setTitle('Manufacturers list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('manufacturersList',$post);

		View::make('admincp/footer');

	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>