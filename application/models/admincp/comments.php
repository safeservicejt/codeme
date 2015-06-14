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
			Comments::remove($id);

			break;
		case 'publish':

			Comments::update($id,array(
				'status'=>1
				));
			break;
		case 'unpublish':
			Comments::update($id,array(
				'status'=>0
				));
			break;
		
	}
}
?>