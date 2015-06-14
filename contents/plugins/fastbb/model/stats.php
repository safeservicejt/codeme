<?php

function summary()
{
	Cache::setPath(THIS_PATH.'caches/');

	if($loadData=Cache::loadKey('summary',60))
	{
		return json_decode($loadData,true);
	}

	$resultData=array();

	$query=Database::query("select count(mangaid) as totalManga from manga_list");

	$row=Database::fetch_assoc($query);

	$resultData['totalManga']=$row['totalManga'];

	$query=Database::query("select count(chapterid) as totalChapters from chapter_list");

	$row=Database::fetch_assoc($query);

	$resultData['totalChapters']=$row['totalChapters'];

	$query=Database::query("select sum(views) as totalViews from chapter_list");

	$row=Database::fetch_assoc($query);

	$resultData['totalChaptersViews']=$row['totalViews'];

	$query=Database::query("select sum(views) as totalViews from manga_list");

	$row=Database::fetch_assoc($query);

	$resultData['totalMangaViews']=$row['totalViews'];

	$resultData['lastestManga']=Manga::get(array(
		'limitShow'=>10,
		'orderby'=>"order by date_added desc"
		));

	$resultData['lastestChapters']=MangaChapters::get(array(
		'limitShow'=>10,
		'query'=>"select mc.*,ml.title as manga_title from chapter_list mc,manga_list ml where mc.mangaid=ml.mangaid order by mc.date_added desc"
		));

	$resultData['viewsManga']=Manga::get(array(
		'limitShow'=>10,
		'orderby'=>"order by views desc"
		));	

	$resultData['viewsChapter']=MangaChapters::get(array(
		'limitShow'=>10,
		'query'=>"select mc.*,ml.title as manga_title from chapter_list mc,manga_list ml where mc.mangaid=ml.mangaid order by mc.views desc"
		));


	Cache::saveKey('summary',json_encode($resultData));
	Cache::resetPath();


	return $resultData;
}

?>