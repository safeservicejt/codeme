<?php


function sendComment($postid)
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

          $send['postid']=$postid;

          if(!$id=Comments::insert($send))
          {
            throw new Exception("Error. Check comment info again!");
            
          }
          else
          {

            throw new Exception("Success. We will review your comment");
            
          }
      }
      else
      {

        throw new Exception("Error Processing Request");
        
      }

      return $alert;
  }
}

?>