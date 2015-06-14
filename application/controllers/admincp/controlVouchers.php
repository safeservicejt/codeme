<?php

class controlVouchers
{
	public function index()
	{
		
		$post=array('alert'=>'');

		Model::load('admincp/vouchers');
		
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
			$post['pages']=Misc::genPage('admincp/vouchers',$curPage);

			$post['theList']=Vouchers::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'orderby'=>'order by voucherid desc',
				'cacheTime'=>5
				));
		}

		if($match=Uri::match('\/edit\/(\d+)'))
		{
			$loadData=Vouchers::get(array(
				'where'=>"where voucherid='".$match[1]."'"
				));

			$post['edit']=$loadData[0];
		}
		
		System::setTitle('Vouchers list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('vouchersList',$post);

		View::make('admincp/footer');

	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>