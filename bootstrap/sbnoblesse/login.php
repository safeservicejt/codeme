<?php

include('headNonSB.php');

?>

    <link href="css/login.css" rel="stylesheet">

    <div class="container">
    	<div class="row" style="margin-top:100px;">
	    	<div class="col-lg-5 col-lg-offset-3">


	    	<!-- row -->
	    	<div class="row">
	    		<div class="col-lg-12 text-center">
	    	<img src="images/logo3128.png" />	    			
	    		</div>
	    	</div>
	    	<!-- row -->
	    	<!-- row -->
	    	<div class="row" style="margin-top:10px;">
	    		<div class="col-lg-12">
					<div class="panel panel-default">
					  <div class="panel-body">
					  	<div id="notify"></div>
					    <p>
					    	<strong>Username:</strong>
					    </p>
					    <p>
					    	<input type="text" class="form-control" placeholder="Username..." name="txtUsername" />
					    </p>
					    <p>
					    	<strong>Password:</strong>
					    </p>
					    <p>
					    	<input type="text" class="form-control" placeholder="Password..." name="txtPassword" />
					    </p>
					    <p>
					    	<button type="button" class="btn btn-primary" id="btnLogin">Login</button>

					    	<a href="sd" class="pull-right">Forgot Password ?</a>
					    </p>

					  </div>
					</div>	    	   			
	    		</div>
	    	</div>
	    	<!-- row -->


	    	</div>    		
    	</div>

    </div>

<?php

include('footerNonSB.php');

?>