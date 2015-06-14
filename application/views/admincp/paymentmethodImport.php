
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Import payment methods</h3>

  </div>
	 <div class="panel-body">

	 <form action="" method="post" enctype="multipart/form-data" >

	 <?php echo $alert;?>
	    <strong>Choose file from your pc</strong><br>

	    <input type="file" name="theFile[]" multiple><br>

	    <button type="submit" class="btn btn-primary" name="btnSend">Upload</button>
	 </form>
	</div>
</div>



