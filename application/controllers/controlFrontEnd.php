<?php

class controlFrontEnd
{
	public function index()
	{
		System::systemStatus();

		// if($match=Uri::match('^(\w+)$'))
		// {
		// 	echo $match[1];
		// }

		$themePath=System::getThemePath().'index.php';

		if(file_exists($themePath))
		{
			Theme::loadShortCode();

			include($themePath);
		}
		else
		{
			Alert::make('Theme not found');
		}
	}
}

?>