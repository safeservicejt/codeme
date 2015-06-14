<?php

function actionProcess()
{
	$id=Request::get('id');

	if(!isset($id[0]))
	{
		return false;
	}

	$listID="'".implode("','", $id)."'";

	$action=Request::get('action');

	// die($action);

	switch ($action) {
		case 'delete':

			Users::remove($id);

			Address::remove($id);

			break;

		
	}
}

function updateProcess($id)
{
	$send=Request::get('send');

	$address=Request::get('address');


	$address['firstname']=$send['firstname'];

	$address['lastname']=$send['lastname'];

	Users::update($id,$send);

	Address::update($id,$address);
	
}


?>