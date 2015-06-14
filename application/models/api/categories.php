<?php

function loadApi($action)
{
	switch ($action) {
		case 'insert':
			
			if(!isset($_SESSION['groupid']))
			{
				throw new Exception("You must be login.");

			}

			try {

				if(!$id=Categories::insert(Request::make('send')))
				{
					throw new Exception("Error. ".Database::$error);
					
				}

				return json_encode(array('error'=>'no'));

			} catch (Exception $e) {

				throw new Exception($e->getMessage());
			}
			
			break;
		case 'get':

			try {

				$data=Categories::get();

				return json_encode($data);

			} catch (Exception $e) {

				throw new Exception($e->getMessage());

			}
			
			break;

	}	
}

?>