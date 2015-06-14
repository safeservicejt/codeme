<?php

function loginProcess()
{
	$valid=Validator::make(array(
		'send.username'=>'min:3|slashes',
		'send.password'=>'min:3|slashes'
		));

	if(!$valid)
	{
		throw new Exception("Error Processing Request");
		
	}

	if(!Captcha::verify())
	{
		throw new Exception("Wrong captcha characters.");
		
	}

	$username=Request::get('send.username');

	$password=Request::get('send.password');

	try {
		Users::makeLogin($username,$password);
	} catch (Exception $e) {
		throw new Exception($e->getMessage());
	}

	Redirect::to(ADMINCP_URL);
}

?>