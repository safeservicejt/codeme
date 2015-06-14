<?php

class controlForgotpass
{
	public function index()
	{
        $postData=array('alert'=>'');

        Model::load('admincp/forgotpass');

        // if(Session::has('userid'))
        // {
        //     Redirect::to(ADMINCP_URL);
        // }

        if(Request::has('btnSend'))
        {
            try {

                forgotProcess();

                $postData['alert']='<div class="alert alert-success">We have been send your new password to your email.</div>';
                
            } catch (Exception $e) {
                $postData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
            }
        }

        $postData['captchaHTML']=Captcha::makeForm();

        System::setTitle('Forgot Password - '.ADMINCP_TITLE);
       
		View::make('admincp/headNonSB');

		View::make('admincp/forgotpass',$postData);

		View::make('admincp/footerNonSB');

	}
    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/nav');
                
        View::make('admincp/left');  
              
        View::make('admincp/startContent');

        View::make('admincp/'.$viewPath,$inputData);

        View::make('admincp/endContent');
         // View::make('admincp/right');

    }
}

?>