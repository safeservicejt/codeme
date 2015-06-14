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
			Reviews::remove($id);

			break;
		case 'publish':

			Reviews::update($id,array(
				'status'=>1
				));
			break;
		case 'unpublish':
			Reviews::update($id,array(
				'status'=>0
				));
			break;
		
	}
}
?>