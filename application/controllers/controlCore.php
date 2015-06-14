<?php

class controlCore
{
	public function index()
	{
		if($match=Uri::match('^(\w+)$'))
		{
			echo $match[1];
		}
	}
}

?>