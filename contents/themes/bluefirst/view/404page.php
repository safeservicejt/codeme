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
	<div class="col-lg-12">
	<div class="well well-post-content">
	<!-- title -->
	<div class="row">
	<div class="col-lg-12"><h2>Page not found</h2></div>
	</div>
	<!-- title -->

	<!-- content -->
	<div class="row">
	<div class="col-lg-12">
	<span>This content not found in our database.</span>
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