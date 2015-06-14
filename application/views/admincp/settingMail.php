
<form action="" method="post" enctype="multipart/form-data">	
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Mail Setting</h3>
  </div>
  <div class="panel-body">
<div class="row">
		<div class="col-lg-12">

			<p><strong>Send mail from local system or other system :</strong></p>
		  	<p>
			<select name="mail[send_method]" id="send_method" class="form-control">
			<option value="local">From local system</option>
				<option value="account">From other system</option>

			</select>
		  	</p>
			<p>Default sender name:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Sender name..." name="mail[fromName]" value="<?php echo $mail['fromName'];?>" />
		  	</p>

			<p>Default sender email:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Sender email..." name="mail[fromEmail]" value="<?php echo $mail['fromEmail'];?>" />
		  	</p>
			<p>SMTP Address:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="SMTP address..." name="mail[smtpAddress]" value="<?php echo $mail['smtpAddress'];?>" />
		  	</p>
			<p>Username:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Username..." name="mail[smtpUser]" value="<?php echo $mail['smtpUser'];?>" />
		  	</p>
			<p>Password:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Password..." name="mail[smtpPass]" value="<?php echo $mail['smtpPass'];?>" />
		  	</p>
			<p>SMTP Port:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="SMTP Port..." name="mail[smtpPort]" value="<?php echo $mail['smtpPort'];?>" />
		  	</p>
			<p>New user email content: (use {email}, {fullname}, {password}, {siteurl})</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Subject..." name="mail[registerSubject]" value="<?php echo $mail['registerSubject'];?>" />
		  	</p>			
		  	<p>
		  	<textarea rows="10" class="form-control" name="mail[registerContent]"><?php echo $mail['registerContent'];?></textarea>
		  	</p>
			<p>Forgot password email content: (use {email}, {fullname}, {password}, {siteurl})</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Subject..." name="mail[forgotSubject]" value="<?php echo $mail['forgotSubject'];?>" />
		  	</p>			
		  	<p>
		  	<textarea rows="10" class="form-control" name="mail[forgotContent]"><?php echo $mail['forgotContent'];?></textarea>
		  	</p>

		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>			  	

		</div>

	</div>    

  </div>
</div>
</form>
<script>

$(document).ready(function(){

setSelect('send_method','<?php echo $mail["send_method"];?>');


});

function setSelect(id,value)
{
	$('#'+id+' option').each(function(){
		var thisVal=$(this).val();

		if(thisVal==value)
		{
			$(this).attr('selected',true);
		}


	});
}
</script>