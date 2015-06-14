<?php 
if(file_exists($filePath))
{


	if(!preg_match('/\//i', $func))
	{
		if(!function_exists($func))
		{
			include($filePath);
		}
		
		$func();					
	}
	else
	{
		$filePath=dirname($filePath).'/';

		$filePath.=$func;

		// die($filePath);

		if(file_exists($filePath))
		{
			include($filePath);
		}
	}

} 

?>