<?php


function searchResult()
{
  $curPage=0;

  $keywords='';

  if($matches=Uri::match('tag\/(.*?)\/page\/(\d+)'))
  {
    $curPage=$matches[2];

    $keywords=$matches[1];

  }
	elseif($matches=Uri::match('tag\/(.*?)$'))
	{
		$curPage=0;

		$keywords=$matches[1];
	}

	// $loadPostNode=PostTags::get(array(
	//     'limitShow'=>10,
	//     'limitPage'=>$curPage,		
	// 	'where'=>"where tag_title LIKE '%$keywords%'"
	// 	));

	// // print_r($loadPostNode);die();

	// $total=count($loadPostNode);

	// $listID='';

	// for($i=0;$i<$total;$i++)
	// {
	// 	$listID.="'".$loadPostNode[$i]['postid']."', ";
	// }

	// $listID=substr($listID, 0, strlen($listID)-2);

	$loadData=Post::get(array(
		'where'=>"where postid IN (select postid from post_tags where title='$keywords')",
		'orderby'=>"group by postid order by date_added"
		));

  	return $loadData;
}
?>