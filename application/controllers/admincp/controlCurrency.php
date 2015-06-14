<?php

class controlCurrency
{
	public function index()
	{
		
		$post=array('alert'=>'');

		Model::load('admincp/currency');
		
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

				$post['alert']='<div class="alert alert-success">Add new currency success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnSave'))
		{
			$match=Uri::match('\/edit\/(\d+)');

			try {
				
				updateProcess($match[1]);

				$post['alert']='<div class="alert alert-success">Update currency success.</div>';

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
			$post['pages']=Misc::genPage('admincp/currency',$curPage);

			$post['theList']=Currency::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'orderby'=>'order by currencyid desc',
				'cacheTime'=>5
				));
		}

		if($match=Uri::match('\/edit\/(\d+)'))
		{
			$loadData=Currency::get(array(
				'where'=>"where currencyid='".$match[1]."'"
				));

			$post['edit']=$loadData[0];
		}

		System::setTitle('Currency list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('currencyList',$post);

		View::make('admincp/footer');

	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>