<?php

function listComments($id)
{
    $resultData='';

    $id=0;

    // $id=$_REQUEST['id'];   

    $loadData=Comments::get(array(
      'limitShow'=>100,
      'where'=>"where postid='$id' AND status='1'"
      ));

    return $loadData;
}

function sendComment()
{
  $alert='';
  
  if(Request::has('btnComment'))
  {
      $valid=Validator::make(array(
        'comment.content'=>'min:10|slashes',
        'comment.fullname'=>'min:3|slashes',
        'comment.email'=>'min:10|email|slashes'
        ));

      if($valid)
      {
          $send=Request::get('comment');

          // print_r($send);die();

          $matches=Uri::match('^post-(\d+)\-');


          $send['postid']=$matches[1];

          if(!$id=Comments::insert($send))
          {
            $alert='<div class="alert alert-warning">Error. Check comment info again!</div>';
          }
          else
          {
            
            $alert='<div class="alert alert-success">Success. We will review your comment!</div>';
          }
      }
      else
      {
        $alert='<div class="alert alert-warning">Error. Check comment info again!</div>';
      }

      return $alert;
  }
}
function postProcess($inputData=array())
{
	$matches=Uri::match('^post-(\d+)\-(.*?)\.html');

	$id=$matches[1];

	$friendly_url=$matches[2];

	$loadData=Post::get(array(
		'where'=>"where postid='$id' AND status='1'"
		));

	if(!isset($loadData[0]['postid']))
	{
    Redirect::to('404page');
		// Alert::make('Page not found');
	}

	// $inputData['title']=$loadData[0]['title'];

	// $inputData['content']=$loadData[0]['content'];

	// $inputData['image']=$loadData[0]['image'];

	// $inputData['views']=$loadData[0]['views'];

	// $inputData['date_added']=Render::dateFormat($loadData[0]['date_added']);

	// $inputData['keywords']=$loadData[0]['keywords'];
	
	// $inputData['friendly_url']=$loadData[0]['friendly_url'];

	// $inputData['is_featured']=$loadData[0]['is_featured'];

  $inputData=array_merge($inputData,$loadData[0]);


	return $inputData;
}


?>