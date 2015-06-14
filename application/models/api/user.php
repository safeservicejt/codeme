<?php

function loadApi($action)
{
	switch ($action) {
		case 'login':
			
			if(isset($_SESSION['userid']))
			{
				throw new Exception("You have been loggedin.");

			}

			$username=Request::get('username','');

			$password=Request::get('password','');

			try {

				Users::makeLogin($username,$password);

				return json_encode(array('error'=>'no','loggedin'=>'yes'));

			} catch (Exception $e) {

				throw new Exception($e->getMessage());
			}
			
			break;
		case 'register':

			try {

				$id=Users::makeRegister();

				return json_encode(array('error'=>'no','userid'=>$id));

			} catch (Exception $e) {

				throw new Exception($e->getMessage());

			}
			
			break;

	}	
}

?>