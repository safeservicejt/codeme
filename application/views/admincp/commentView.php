<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">View comment #<?php echo $edit['commentid'];?> of post <?php echo $edit['title'];?></h3>
  </div>
  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
        <p>
            <strong><?php echo $edit['fullname'];?></strong>
            <br>
            <small>Date: <?php echo $edit['date_added'];?></small>
            <br>
            <small>Email: <?php echo $edit['email'];?></small>

        </p>
        <hr>
    	<?php echo $edit['content'];?>
    	</div>
    	
    </div>
  </div>
</div>

