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

<?php

$li='';

$total=count($newPost);

if(isset($newPost[0]['postid']))
for($i=0;$i<$total;$i++)
{
  $thumbnail='';

  if(isset($newPost[$i]['imageUrl'][5]))
  {
    $thumbnail='
    <div class="col-lg-12">
    <img src="'.$newPost[$i]['imageUrl'].'" class="img-responsive" />
    </div>
    ';
  }

  $li.='
  <!-- items -->
  <div class="row">
  '.$thumbnail.'
  <div class="col-lg-12">
  <div class="well well-post-content">
  <!-- title -->
  <div class="row">
  <div class="col-lg-12"><a href="'.$newPost[$i]['url'].'"><h2>'.$newPost[$i]['title'].'</h2></a></div>
  </div>
  <!-- title -->
  <!-- post info -->
  <div class="row">
  <div class="col-lg-12">
  <p>
    <span class="glyphicon glyphicon-calendar" title="Date Created"></span> <span title="Date Created">'.$newPost[$i]['date_added'].'</span>
    &nbsp;&nbsp;
    <span class="glyphicon glyphicon-globe" title="Views"></span> <span title="Views">'.$newPost[$i]['views'].'</span>

  </p>
  </div>
  </div>
  <!-- post info -->

  <!-- content -->
  <div class="row">
  <div class="col-lg-12">
  '.Render::rawContent($newPost[$i]['content'],0,500).'
  </div>
  </div>
  <!-- content -->

  <!-- read more -->
  <div class="row">
  <div class="col-lg-12 text-right"><br>
  <a href="'.$newPost[$i]['url'].'" class="btn btn-danger">Read more</a>
  </div>
  </div>
  <!-- read more -->





  </div>
  </div>

  </div>
  <!-- items -->


  ';
}
else
{
  $li='
  <!-- items -->
  <div class="row">
  <div class="col-lg-12">
  <div class="well well-post-content">
  <!-- title -->
  <div class="row">
  <div class="col-lg-12"><h2>No result</h2></div>
  </div>
  <!-- title -->

  <!-- content -->
  <div class="row">
  <div class="col-lg-12">
  <span>We can not found any result with in this category.</span>
  </div>
  </div>
  <!-- content -->

  </div>
  </div>

  </div>
  <!-- items -->

  ';
}

echo $li;

?>
<!-- page -->
<div class="row">
  <div class="col-lg-12 text-right">
   <?php echo $listPage;?>                               
  </div>
</div>
<!-- page -->

</div>
<!-- left -->
<!-- right -->
<?php View::makeWithPath('right',array(),$themePath);?>
<!-- right -->
</div>

</div>
<!-- body -->