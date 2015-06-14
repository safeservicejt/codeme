<?php


function listPage()
{
  $curPage=0;


  if($matches=Uri::match('page\/(\d+)'))
  {
    $curPage=$matches[1];
  }

  $listPage=Misc::genPage('home',$curPage); 

  return $listPage;

}

?>