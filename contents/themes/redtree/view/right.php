
<!-- right -->
<div class="col-lg-4">
<div class="well well-modern">

<!-- widget -->
<form action="<?php echo ROOT_URL;?>search" method="post" enctype="multipart/form-data">
<div class="row">
<div class="col-lg-12">
<h4><strong>SEARCH</strong></h4>
</div>
<div class="col-lg-12">
    <div class="input-group">
      <input type="text" class="form-control" name="txtKeywords" placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn btn-danger" type="submit"><span class="glyphicon glyphicon-search"></span></button>
      </span>
    </div><!-- /input-group -->
</div>

</div>
</form>
<!-- widget -->
<!-- widget -->
<?php
$categories=Categories::get(array(
  'where'=>"where parentid='0'"
  ));

$li='';

$total=count($categories);

if(isset($categories[0]['catid']))
for($i=0;$i<$total;$i++)
{
  $li.='<li><a href="'.$categories[$i]['url'].'">'.$categories[$i]['cattitle'].'</a></li>';
}

$listCat=$li;
?>
<div class="row">
<div class="col-lg-12">
<h4><strong>CATEGORIES</strong></h4>
<ul class="ulMenu1">
  <?php echo $listCat;?>
</ul>
</div>
</div>
<!-- widget -->

<?php
$post=Post::get(array(
    'limitShow'=>10,
    'orderby'=>'order by views desc'
    ));

$total=count($post);

$li='';

if(isset($post[0]['postid']))
for($i=0;$i<$total;$i++)
{
  $li.='
<li><span class="glyphicon glyphicon-bookmark"></span> <a href="'.$post[$i]['url'].'">'.$post[$i]['title'].'</a><br><span title="Date created">'.$post[$i]['date_added'].'</span></li>

  ';
}

$listPost=$li;

?>
<!-- widget -->
<div class="row">
<div class="col-lg-12">
<h4><strong>POPULAR POST</strong></h4>
<ul class="ulMenu2">
  <?php echo $listPost;?>
</ul>
</div>
</div>
<!-- widget -->

<?php 
$tags=PostTags::get(array(
  'limitShow'=>10,
  'orderby'=>'group by tag_title order by count(tag_title) desc'
  ));

$total=count($tags);

$li='';

if(isset($tags[0]['tagid']))
for($i=0;$i<$total;$i++)
{
  $li.='
<li><a href="'.$tags[$i]['url'].'">'.$tags[$i]['tag_title'].'</a></li>
  ';
}

$listTag=$li;

?>
<!-- widget -->
<div class="row">
<div class="col-lg-12">
<h4><strong>TAGS</strong></h4>
<ul class="ulTag">
  <?php echo $listTag;?>

</ul>

</div>
</div>
<!-- widget -->


</div>
</div>
<!-- right -->