
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
	    		<div class="col-lg-12">
					<div class="panel panel-default">
					  <div class="panel-body">
					  	<div class="row">
					  		<div class="col-lg-6">
					  		<?php echo $alert;?>
							    <p>
							    	<strong>Username:</strong>
							    </p>
							    <p>
							    	<input type="text" class="form-control" placeholder="Username..." name="send[username]" id="txtUsername" required />
							    </p>
							    <p>
							    	<strong>Password:</strong>
							    </p>
							    <p>
							    	<input type="password" class="form-control" placeholder="Password..." name="send[password]" id="txtPassword" required />
							    </p>					  			
					  		</div>
					  		<div class="col-lg-5 col-lg-offset-1" style="padding-top:20px;">
							    <?php echo $captchaHTML;?>				  			
					  		</div>

					  	</div>

					  	<div class="row">
					  		<div class="col-lg-6">
							    <p>
							    	<button type="submit" class="btn btn-primary" name="btnLogin">Login</button>

							    	<a href="<?php echo ADMINCP_URL;?>forgotpass" class="pull-right">Forgot Password ?</a>
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