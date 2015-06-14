<?php

Plugins::install('install_bbcodeHide');

function install_bbcodeHide()
{

	Shortcode::add('hide','parse_bbcodeHide');

	// Add admincp left menu

	// Plugins::add('admincp_menu','bbcodeHide_admincp_menu');
	// Plugins::add('site_header','bbcodeHide_site_header');

}

function bbcodeHide_site_header()
{
	return '<script>alert("ok");</script>';
}

function bbcodeHide_admincp_menu()
{
	$menu=array(
			array(
				'title'=>'Test menu 1',
				'link'=>'http://google.com.vn',
				'redirect'=>'yes'
				),
			array(
				'title'=>'Test menu 2',
				'child'=>array(
						0=>array(
							'title'=>'Child 1',
							'link'=>'http://google.com'
							),
						1=>array(
							'title'=>'Child 2',
							'link'=>'http://google.com'
							),
						2=>array(
							'title'=>'Child 3',
							'link'=>'http://google.com'
							)
					)

				),
			array(
				'title'=>'Test menu 3',
				'func'=>'bbcodeHide_setting'
				)
		);

	return $menu;
}

function bbcodeHide_setting()
{
	echo 'ok';
}

function parse_bbcodeHide($loadData='')
{

	if(!isset($_SESSION['userid']))
	{
		$loadData=preg_replace('/\[hide\].*?\[\/hide\]/is', '<p><strong><i>You must login to see this content.</i></strong></p>', $loadData);
	}

	return $loadData;
}

?>