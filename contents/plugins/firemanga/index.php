<?php

Plugins::install('install_firemanga');

Plugins::uninstall('uninstall_firemanga');

function install_firemanga()
{

	$installPath=dirname(__FILE__).'/install/';

	$dbFile=$installPath.'db.sql';

	if(file_exists($dbFile))
	{
		Database::import($dbFile);
	}

	File::copy($installPath.'Manga.php',ROOT_PATH.'includes/Manga.php');

	File::copy($installPath.'MangaAuthors.php',ROOT_PATH.'includes/MangaAuthors.php');

	File::copy($installPath.'MangaCategories.php',ROOT_PATH.'includes/MangaCategories.php');

	File::copy($installPath.'MangaChapters.php',ROOT_PATH.'includes/MangaChapters.php');

	File::copy($installPath.'MangaTags.php',ROOT_PATH.'includes/MangaTags.php');

	Plugins::add('admincp_menu','firemanga_admincp_menu');

}

function firemanga_admincp_menu()
{
	$menu=array(
			array(
				'title'=>'FireManga',
				'child'=>array(
						0=>array(
							'title'=>'Statistics',
							'controller'=>'stats'
							),
						1=>array(
							'title'=>'Manga List',
							'controller'=>'manga'
							),
						2=>array(
							'title'=>'Chapter List',
							'controller'=>'chapter'
							),
						3=>array(
							'title'=>'Auto Leech',
							'controller'=>'leech'
							)

					)

				)
		);

	return $menu;	
}

function uninstall_firemanga()
{
	Database::query('drop table chapter_list');

	Database::query('drop table manga_authors');

	Database::query('drop table manga_categories');

	Database::query('drop table manga_list');	
	
	Database::query('drop table manga_tags');	

	if(file_exists(ROOT_PATH.'includes/Manga.php'))
	{
		unlink(ROOT_PATH.'includes/Manga.php');
	}

	if(file_exists(ROOT_PATH.'includes/MangaAuthors.php'))
	{
		unlink(ROOT_PATH.'includes/MangaAuthors.php');
	}

	if(file_exists(ROOT_PATH.'includes/MangaCategories.php'))
	{
		unlink(ROOT_PATH.'includes/MangaCategories.php');
	}

	if(file_exists(ROOT_PATH.'includes/MangaChapters.php'))
	{
		unlink(ROOT_PATH.'includes/MangaChapters.php');
	}

	if(file_exists(ROOT_PATH.'includes/MangaTags.php'))
	{
		unlink(ROOT_PATH.'includes/MangaTags.php');
	}

}

?>