<?php

class SelfApi
{
	public function route()
	{
		$listRoute=array(
			'add_new_post'=>'insertPost'
			);


		return $listRoute;
	}

	public function insertPost()
	{
		echo 'OK';
	}
	
}


?>