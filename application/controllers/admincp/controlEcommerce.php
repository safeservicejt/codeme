<?php

class controlEcommerce
{
	public function index()
	{

		Model::load('admincp/ecommerce');

		$post=countStats();

		System::setTitle('Ecommerce Stats - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('ecommerceView',$post);

		View::make('admincp/footer');


	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>