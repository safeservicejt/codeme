<?php

function contactProcess()
{
	if(Session::has('contactus'))
	{
		$total=(int)Session::get('contactus');

		if($total >= 5)
		{
			Redirect::to('404page');
			// Alert::make('Page not found'); 
		}
	}

	$valid=Validator::make(array(
		'send.fullname'=>'min:2|slashes',
		'send.email'=>'min:5|slashes',
		'send.content'=>'min:3|slashes'
		));

	if(!$valid)
	{
		$alert='<div class="alert alert-warning">'.Lang::get('frontend/contactus.errorSend').'</div>';

		return $alert;
	}

	if(!$id=Contactus::insert(Request::get('send')))
	{
		$alert='<div class="alert alert-warning">'.Lang::get('frontend/contactus.errorSend').'</div>';

		return $alert;		
	}

	if(Session::has('contactus'))
	{
		$total=(int)Session::get('contactus');

		$total++;

		Session::make('contactus',$total);
	}
	else
	{
		Session::make('contactus','1');
	}

	

		$alert='<div class="alert alert-success">'.Lang::get('frontend/contactus.successSend').'</div>';

		return $alert;	
}


?>