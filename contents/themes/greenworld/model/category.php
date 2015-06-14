<?php

function searchResult($id)
{
  $curPage=0;

  $keywords='';

  if($matches=Uri::match('category-(\d+)-\w+-page-(\d+)'))
  {
    $curPage=$matches[2];

    $keywords=$matches[1];
  }
  else
  {
    $keywords=$id;
  }

  $loadData=Post::get(array(
    'limitShow'=>10,
    'limitPage'=>$curPage,
    'where'=>"where catid='$keywords'"
    ));

  if(!isset($loadData[0]['postid']))
  {
    Redirect::to('404page');
  }

  return $loadData;
}

function listPage()
{
  $curPage=0;

  $id=0;

  $friendly_url='';

  if($matches=Uri::match('category-(\d+)-([a-zA-Z0-9_-]+)-page-(\d+)'))
  {
    $curPage=$matches[3];

    $id=$matches[1];

    $friendly_url=$matches[2];

  }elseif($matches=Uri::match('category-(\d+)-([a-zA-Z0-9_-]+)'))
  {
    $id=$matches[1];

    $friendly_url=$matches[2];
  }

  $listPage=Misc::genPage('category-'.$id.'-'.$friendly_url,$curPage,5,'-'); 

  return $listPage;

}


?>