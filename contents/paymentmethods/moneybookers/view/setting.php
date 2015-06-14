
<!-- row -->
<div class="row">

	<div class="col-lg-12 table-responsive">
	<?php echo $alert;?>
	<form action="" method="post" enctype="multipart/form-data">
	<table class="table table-hover">
	<tbody>

	<!-- tr -->
		<tr>
		<td class="col-lg-3" style="padding-top:15px;"><strong>Email:</strong></td>
		<td class="col-lg-9">
		<input type="email" class="form-control" placeholder="Email.." name="send[email]" value="<?php if(isset($data['email']))echo $data['email'];?>" required>
		</td>

		</tr>
	<!-- tr -->

	<!-- tr -->
		<tr>
		<td class="col-lg-3" style="padding-top:15px;"><strong>Secret:</strong></td>
		<td class="col-lg-9">
		<input type="text" class="form-control" placeholder="Secret.." name="send[secret]" value="<?php if(isset($data['secret']))echo $data['secret'];?>" required>
		</td>

		</tr>
	<!-- tr -->
	</tbody>
	</table>

	<p>
		<button type="submit" class="btn btn-primary" name="btnSend">Save changes</button>
		<a href="<?php echo ADMINCP_URL;?>paymentmethods" class="btn btn-default pull-right">Back</a>
	</p>

	</form>
	</div>
</div>

<!-- row -->