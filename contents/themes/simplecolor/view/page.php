
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

<!-- content -->
<div class="row">
<div class="col-lg-12">
<?php echo $content;?>
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