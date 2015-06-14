<?php

class controlApi
{
	public function index()
	{
		if($match=Uri::match('^api\/(\w+)'))
		{
			Model::load('api');

			try {

				apiProcess();

			} catch (Exception $e) {

				echo $e->getMessage();
				
			}
		}
		else
		{
			echo json_encode(array('error'=>'yes'));
		}
	}
}

?>