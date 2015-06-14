<?php

class controlCoupons
{
	public function index()
	{
		
		$post=array('alert'=>'');

		Model::load('admincp/coupons');
		
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

				$post['alert']='<div class="alert alert-success">Add new coupon success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		if(Request::has('btnSave'))
		{
			$match=Uri::match('\/edit\/(\d+)');

			try {
				
				updateProcess($match[1]);

				$post['alert']='<div class="alert alert-success">Update coupon success.</div>';

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
			$post['pages']=Misc::genPage('admincp/coupons',$curPage);

			$post['theList']=Coupons::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'orderby'=>'order by couponid desc',
				'cacheTime'=>5
				));
		}

		if($match=Uri::match('\/edit\/(\d+)'))
		{
			$loadData=Coupons::get(array(
				'where'=>"where couponid='".$match[1]."'"
				));

			$post['edit']=$loadData[0];
		}
		
		System::setTitle('Coupons list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('couponsList',$post);

		View::make('admincp/footer');

	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>