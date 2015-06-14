
<!-- row -->
<div class="row">

	<div class="col-lg-12 table-responsive">
	<?php echo $alert;?>
	<form action="" method="post" enctype="multipart/form-data">
	<table class="table table-hover">
	<tbody>

	<!-- tr -->
		<tr>
		<td class="col-lg-3" style="padding-top:15px;"><strong>Merchant ID:</strong></td>
		<td class="col-lg-9">
		<input type="text" class="form-control" placeholder="Merchant ID.." name="send[merchant_id]" value="<?php if(isset($data['merchant_id']))echo $data['merchant_id'];?>" required>
		</td>

		</tr>
	<!-- tr -->

	<!-- tr -->
		<tr>
		<td class="col-lg-3" style="padding-top:15px;"><strong>Security Code:</strong></td>
		<td class="col-lg-9">
		<input type="text" class="form-control" placeholder="Security Code.." name="send[secret]" value="<?php if(isset($data['secret']))echo $data['secret'];?>" required>
		</td>

		</tr>
	<!-- tr -->
	<!-- tr -->
		<tr>
		<td class="col-lg-3" style="padding-top:15px;"><strong>Alert url:</strong></td>
		<td class="col-lg-9">
		<input type="text" class="form-control" disabled placeholder="Alert url.." value="<?php echo ROOT_URL;?>payment/verify/payza" >
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