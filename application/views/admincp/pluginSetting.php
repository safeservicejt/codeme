<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $title;?></h3>
  </div>
  <div class="panel-body">

<div class="row">
		<div class="col-lg-12">

			<div class="row">

			<?php if(file_exists($filePath)) include($filePath);?>

			</div>
		</div>

	</div>
  </div>
</div>

