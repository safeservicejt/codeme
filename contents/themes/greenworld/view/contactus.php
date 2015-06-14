
<!-- body -->
<div class="container">

<!-- slide -->
<div class="row">
<div class="col-lg-12">

</div>
</div>
<!-- slide -->


<?php echo $content_top;?>
<div class="row">
<!-- left -->
<div class="col-lg-8">
<?php echo $content_left;?>
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
<div class="col-lg-12"><a href="sdsd"><h2><?php echo Lang::get('frontend/contactus.title');?></h2></a></div>
</div>
<!-- title -->
<!-- content -->
<div class="row">
<div class="col-lg-12">
<form action="" method="post" enctype="multipart/form-data">
		<?php echo $alert;?>
		<p>
		<label><strong><?php echo Lang::get('frontend/contactus.fullname');?></h3></div>
	<div class="col-lg-12"></strong></label>
		<input type="text" class="form-control" placeholder="<?php echo Lang::get('frontend/contactus.fullname');?>" name="send[fullname]" required />
		</p>
		<p>
		<label><strong><?php echo Lang::get('frontend/contactus.email');?></h3></div>
	<div class="col-lg-12"></strong></label>
		<input type="email" class="form-control" placeholder="<?php echo Lang::get('frontend/contactus.email');?>" name="send[email]" required />
		</p>
		<p>
		<label><strong><?php echo Lang::get('frontend/contactus.content');?></h3></div>
	<div class="col-lg-12"></strong></label>
		<textarea rows="10" class="form-control" placeholder="<?php echo Lang::get('frontend/contactus.content');?>" name="send[content]"></textarea>
		</p>

		<button type="submit" class="btn btn-primary" name="btnSend"><?php echo Lang::get('frontend/contactus.btnSend');?></button>

		<a href="<?php echo ROOT_URL;?>" class="btn btn-default pull-right"><?php echo Lang::get('frontend/contactus.btnBack');?></a>
	</form>
</div>
</div>
<!-- content -->

</div>
</div>

</div>
<!-- items -->


</div>
<!-- left -->

<!-- right -->
<?php Theme::view('right');?>
<?php echo $content_right;?>
<!-- right -->
</div>
<?php echo $content_bottom;?>
</div>
<!-- body -->