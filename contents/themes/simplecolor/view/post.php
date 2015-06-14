
<!-- body -->
<div class="container">

<!-- slide -->
<div class="row">
<div class="col-lg-12">

</div>
</div>
<!-- slide -->


<div class="row">
<!-- left -->
<div class="col-lg-8">
<!-- items -->
<div class="row">
<?php
  $thumbnail='';

  if(isset($imageUrl[5]))
  {
    $thumbnail='
    <div class="col-lg-12">
    <img src="'.$imageUrl.'" class="img-responsive" />
    </div>
    ';
  }

  echo $thumbnail;

?>
<div class="col-lg-12">
<div class="well well-post-content">
<!-- title -->
<div class="row">
<div class="col-lg-12"><a href="<?php echo $url;?>"><h2><?php echo $title;?></h2></a></div>
</div>
<!-- title -->
<!-- post info -->
<div class="row">
<div class="col-lg-12">
<p>
  <span class="glyphicon glyphicon-calendar" title="Date Created"></span> <span title="Date Created"><?php echo $date_added;?></span>
  &nbsp;&nbsp;
  <span class="glyphicon glyphicon-globe" title="Views"></span> <span title="Views"><?php echo $views;?></span>

</p>
</div>
</div>
<!-- post info -->

<!-- content -->
<div class="row">
<div class="col-lg-12">
<?php echo $content;?>
</div>
</div>
<!-- content -->

<!-- tags -->

<div class="row">
<div class="col-lg-12">
<hr>
<strong>Tags:</strong>
<ul class="ulTag">
<?php echo $listTag;?>
</ul>
</div>
</div>
<!-- tags -->
</div>
</div>

</div>
<!-- items -->

<?php if((int)$allowcomment==1){ ?>
<!-- Comment box -->
<form action="" method="post" enctype="multipart/form-data">
<div class="row">
<div class="col-lg-12">
<div class="well  well-post-content well-comment-box">
<!-- row -->
<div class="row">
<div class="col-lg-12">
<?php if(isset($commentAlert))echo $commentAlert;?>
<label>Fullname:</label>
<input type="text" name="comment[fullname]" class="form-control" placeholder="Fullname..." required />
</div>
<div class="col-lg-12"><br>
<label>Email:</label>
<input type="email" name="comment[email]"  class="form-control" placeholder="Email..." required />
</div>
<div class="col-lg-12"><br>
<label>Content:</label>
<textarea rows="10" name="comment[content]"  class="form-control"></textarea>
</div>
</div>
<!-- row -->
<!-- row -->
<div class="row">
<div class="col-lg-12"><br>
<button type="submit" class="btn btn-primary" name="btnComment" id="btnComment">Send</button>
</div>
</div>
<!-- row -->


</div>
</div>

</div>
</form>
<!-- Comment box -->
<?php } ?>

<?php if((int)$allowcomment==1){ ?>
<!-- Comment list -->
<?php
$total=count($listComments);

$li='';

if(isset($listComments[0]['postid']))
for($i=0;$i<$total;$i++)
{
  $li.='
<li>
  <div class="row">
  <div class="col-lg-12">
  <h4>'.$listComments[$i]['fullname'].'</h4>
  <small>'.$listComments[$i]['date_added'].'</small>
  <hr>
  <p>
    <span>
      '.$listComments[$i]['content'].'
    </span>
  </p>
  </div>
  </div>
</li>

  ';
}

$comments=$li;
?>

<div class="row">
<div class="col-lg-12">
<div class="well  well-post-content">
<ul class="post-list-comment">
<?php echo $comments;?>
</ul>
</div>
</div>
</div>
<!-- Comment list -->
<?php } ?>

</div>
<!-- left -->

<!-- right -->
<?php View::makeWithPath('right',array(),$themePath);?>
<!-- right -->
</div>
</div>
<!-- body -->