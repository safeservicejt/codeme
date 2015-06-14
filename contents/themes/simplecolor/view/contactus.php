
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

<div class="col-lg-12">
<div class="well well-post-content">
<!-- title -->
<div class="row">
<div class="col-lg-12"><a href="#"><h2>Contact us</h2></a></div>
</div>
<!-- title -->
<!-- content -->
<div class="row">
<div class="col-lg-12">
<form action="" method="post" enctype="multipart/form-data">
		<?php echo $alert;?>
		<p>
		<label><strong>Fullname</h3></div>
	<div class="col-lg-12"></strong></label>
		<input type="text" class="form-control" placeholder="Fullname" name="send[fullname]" required />
		</p>
		<p>
		<label><strong>Email</h3></div>
	<div class="col-lg-12"></strong></label>
		<input type="email" class="form-control" placeholder="Email" name="send[email]" required />
		</p>
		<p>
		<label><strong>Content</h3></div>
	<div class="col-lg-12"></strong></label>
		<textarea rows="10" class="form-control" placeholder="Content" name="send[content]"></textarea>
		</p>

		<button type="submit" class="btn btn-primary" name="btnSend">Send</button>

		<a href="<?php echo ROOT_URL;?>" class="btn btn-default pull-right">Back</a>
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
<?php View::makeWithPath('right',array(),$themePath);?>
<!-- right -->
</div>
</div>
<!-- body -->