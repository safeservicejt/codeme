<?php

function apiProcess()
{
	if(!$match=Uri::match('^api\/(\w+)\/(\w+)'))
	{
		$result=json_encode(array('error'=>'yes','message'=>'Api not valid'));

		echo $result;

		die();
	}

	$method=strtolower($match[1]);

	$action=strtolower($match[2]);

	$result=array('error'=>'no','message'=>'');
	
	switch ($method) {
		
		case 'cart':
			try {
				$result['data']=Cart::api($action);
			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}

			break;
		
		case 'order':
			try {
				$result['data']=Orders::api($action);
			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}

			break;

		case 'user':
			try {
				$result['data']=Users::api($action);
			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}
			break;

		case 'category':
			try {
				$result['data']=Categories::api($action);
			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}
			break;

		case 'plugin':
			try {

				$foldername=$action;

				$result['data']=PluginsApi::get($foldername);

			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}
			
			break;
		case 'payment':
			try {

				$foldername=$action;

				$result['data']=PaymentApi::get($foldername);

			} catch (Exception $e) {
				$result=array('error'=>'yes','message'=>$e->getMessage());
			}

			break;
		
	}

	echo json_encode($result);
}
?>