<?php

class controlLogin
{
	public function index()
	{
        $postData=array('alert'=>'');

        Model::load('admincp/login');

        // if(Session::has('userid'))
        // {
        //     Redirect::to(ADMINCP_URL);
        // }

        if(Request::has('btnLogin'))
        {
            try {

                loginProcess();

                Redirect::to(ADMINCP_URL);
                
            } catch (Exception $e) {
                $postData['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
            }
        }

        $postData['captchaHTML']=Captcha::makeForm();

        System::setTitle('Login - '.ADMINCP_TITLE);
        
		View::make('admincp/headNonSB');

		View::make('admincp/login',$postData);

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