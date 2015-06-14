
    <link href="<?php echo ROOT_URL;?>bootstrap/sbnoblesse/css/login.css" rel="stylesheet">

    <form action="" method="post" enctype="multipart/form-data">
    <div class="container">
    	<div class="row" style="margin-top:100px;">
	    	<div class="col-lg-8 col-lg-offset-2">


	    	<!-- row -->
	    	<div class="row">
	    		<div class="col-lg-12 text-center">
	    	<img src="<?php echo ROOT_URL;?>bootstrap/sbnoblesse/images/logo3128.png" />	    			
	    		</div>
	    	</div>
	    	<!-- row -->
	    	<!-- row -->
	    	<div class="row" style="margin-top:10px;">
	    		<div class="col-lg-6 col-lg-offset-3">
					<div class="panel panel-default">
					<div class="panel-heading">Forgot Password ?</div>
					  <div class="panel-body">
					  	<div class="row">
					  		<div class="col-lg-12">
					  		<?php echo $alert;?>
							    <p>
							    	<strong>Email:</strong>
							    </p>
							    <p>
							    	<input type="email" class="form-control" placeholder="Email..." name="send[email]" id="txtUsername" required />
							    </p>
							    <p style="margin-top:20px;">
							    	<strong>Enter captcha:</strong>
							    </p>							    
							    <p>
							    	<div class="pull-right"><?php echo $captchaHTML;?></div>	
							    </p>
							    <p>
							    	<button type="submit" class="btn btn-primary" name="btnSend">Send password</button>

							    	<a href="<?php echo ADMINCP_URL;?>" class="pull-right">< Back to login</a>
							    </p>								    				  			
					  		</div>

					  	</div>



					  </div>
					</div>	    	   			
	    		</div>
	    	</div>
	    	<!-- row -->


	    	</div>    		
    	</div>

    </div>
    </form>