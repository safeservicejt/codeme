<?php

function listPage()
{
	$curPage=0;

	$keywords='';

	if($matches=Uri::match('search\/keyword\/(.*?)\/page\/(\d+)'))
	{
		$curPage=$matches[2];

		$keywords=$matches[1];
	}
	else
	{
		$keywords=base64_encode(Request::get('txtKeywords'));
	}

	$listPage=Misc::genPage('search/keyword/'.$keywords,$curPage);	

  $result=array(
    'pages'=>$listPage,
    'keywords'=>base64_decode($keywords)
    );

	return $result;

}


function searchResult()
{
  $curPage=0;

  $keywords='';

  if($matches=Uri::match('search\/keyword\/(.*?)\/page\/(\d+)'))
  {
    $curPage=$matches[2];

    $keywords=base64_decode($matches[1]);
  }
  else
  {
  	$keywords=Request::get('txtKeywords','');
  }


	$loadData=Post::get(array(
		'limitShow'=>24,
		'limitPage'=>$curPage,
		'where'=>"where title LIKE '%$keywords%'"
		));

  return $loadData;
}
?>