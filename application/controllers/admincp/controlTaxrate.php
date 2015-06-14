<?php

class controlTaxrate
{
	public function index()
	{
		
		$post=array('alert'=>'');

		Model::load('admincp/taxrate');
		
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

				$post['alert']='<div class="alert alert-success">Add new category success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnSave'))
		{
			$match=Uri::match('\/edit\/(\d+)');

			try {
				
				updateProcess($match[1]);

				$post['alert']='<div class="alert alert-success">Update category success.</div>';

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
			$post['pages']=Misc::genPage('admincp/taxrate',$curPage);

			$post['theList']=Taxrates::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'orderby'=>'order by taxid desc',
				'cacheTime'=>5
				));
		}

		if($match=Uri::match('\/edit\/(\d+)'))
		{
			$loadData=Taxrates::get(array(
				'where'=>"where taxid='".$match[1]."'"
				));

			$post['edit']=$loadData[0];


			if(strlen($loadData[0]['country_short']) > 0)
			$post['edit']['countries']=explode(',', $loadData[0]['country_short']);

			// print_r($post['countries']);die();
		}

		$post['listCountries']=Country::get();


		System::setTitle('Taxrate list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('taxrateList',$post);

		View::make('admincp/footer');

	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>