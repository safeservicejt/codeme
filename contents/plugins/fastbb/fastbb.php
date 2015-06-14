<?php

Plugins::install('install_fastbb');

Plugins::uninstall('uninstall_fastbb');

function install_fastbb()
{

	$installPath=dirname(__FILE__).'/install/';

	$dbFile=$installPath.'db.sql';

	if(file_exists($dbFile))
	{
		Database::import($dbFile);
	}

	File::copy($installPath.'Manga.php',ROOT_PATH.'includes/Manga.php');

	Plugins::add('admin_left_menu',array(
		'text'=>'FastBB System',
		'filename'=>'load.php',
		'child_menu'=>array(
						0=>array(
						'text'=>'Manga List',
						'filename'=>'controller/controlManga.php'
						)
		)
		));



}

function uninstall_fastbb()
{
	Database::query('drop table chapter_list');


	if(file_exists(ROOT_PATH.'includes/Manga.php'))
	{
		unlink(ROOT_PATH.'includes/Manga.php');
	}


}

?>