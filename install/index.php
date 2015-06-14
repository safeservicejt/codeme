<?php
ob_start();
session_start();
error_reporting(0);

// include('../config.php');

include('../includes/Request.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Install your site - Noblesse CMS</title>

    <!-- Bootstrap theme -->
     <link href="css/cosmo.css" rel="stylesheet">
	
	   <link href="css/custom.css" rel="stylesheet">

<link href="css/wait.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	  <script src="js/jquery-2.1.1.min.js"></script>
      <script src="js/jquery-2.1.1.min.map"></script>
		
  </head>

  <body>

  <div class="wrapper">
<div id="preloader_1">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
</div>

  <div class="container">


    <div class="row" style="margin-top:10px;">

        <div class="col-lg-7 col-lg-offset-2">
           
           <div class="row">
              <div class="col-lg-12 text-center">
                <h1>noblesse cms,</h1>
              </div>
           </div>

           <div class="row panel-1">
              <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <h4>Welcome to <strong>Noblesse CMS</strong> install !</h4>
                  <p>
                  Before getting started, we need some information on the database. You will need to know the following items before proceeding.

                  </p>
                  <p>
                  Database name
                  </p>
                  <p>
                  Database username
                  </p>
                  <p>
                  Database password
                  </p>
                  <p>
                  Database host
                  </p>
                    <p>
                      <button type="button" href="index.php?step=2" class="btn btn-primary btnNextStep pull-right">Next step</button>

                    </p>
                  </div>
                </div> 
              </div>
<!--               <div class="col-lg-12">
                    <p>
                      <a href="index.php?step=2" class="btn btn-primary pull-right">Next step</a>

                    </p>
              </div> -->


           </div>


           <div class="row panel-2">
              <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-body">
                  <h4>Complete below form:</h4>

                    <!-- notify -->
                    <div class="row">
                    <div class="col-lg-12 notifyPanel-2">

                    </div>
                    </div>

                    <div class="row">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="col-lg-6">
                        <strong>Database Name</strong><br>
                          <input type="text" class="form-control txtDBName" name="info[dbname]" value="<?php echo Request::get('info.dbname','');?>" placeholder="Auto create if blank" required />

                          <br>
                          <strong>User Name</strong><br>
                          <input type="text" class="form-control txtDBUser" name="info[dbuser]" value="<?php echo Request::get('info.dbuser','root');?>" placeholder="User Name" required />
                          <br>
                          <strong>Password</strong><br>
                          <input type="text" class="form-control txtDBPass" name="info[dbpass]" value="<?php echo Request::get('info.dbpass','admin');?>" placeholder="Password" />
                          <br>
                          <strong>Database Host</strong><br>
                          <input type="text" class="form-control txtDBHost" name="info[dbhost]" value="<?php echo Request::get('info.dbhost','localhost');?>" placeholder="Database Host" />
                           <br>
                          <strong>Database Port</strong><br>
                          <input type="text" class="form-control txtDBPort" name="info[dbport]" value="<?php echo Request::get('info.dbport','3306');?>" placeholder="Database Port" required />
 
                        </div>
                        <div class="col-lg-6">
                        <strong>Your site url:</strong><br>
                          <input type="url" class="form-control txtUrl" name="info[url]" value="<?php echo Request::get('info.url','http://'.$_SERVER['SERVER_NAME'].'/');?>" placeholder="http://yoursite.com/" required />

                          <br>
                          <strong>Your site path</strong><br>
                          <input type="text" class="form-control txtPath" name="info[path]" value="<?php echo Request::get('info.path',dirname(dirname(__FILE__))).'/';?>" placeholder="/home/yoursite/" required />
                          <br>
                          <strong>Administrator email:</strong><br>
                          <input type="email" class="form-control txtUsername" name="info[username]" value="<?php echo Request::get('info.username','admin@gmail.com');?>" required />
                          <br>
                          <strong>Administrator password</strong><br>
                          <input type="text" class="form-control txtPassword" name="info[password]" value="<?php echo Request::get('info.password','password');?>" required />


                        </div>

                        <div class="col-lg-12" style="margin-top:10px;">

                          <button type="button" class="btn btn-primary btnSend" name="btnSend">Submit</button>

                          <button type="button" class="btn btn-info btnContinue pull-right" name="btnContinue">Complete</button>
                  


                        </div>

                        </form>

                    </div>


                  </div>
                </div> 
              </div>


           </div>

           <div class="row panel-3">
              <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-body">
                  <h4>Completed intall:</h4>
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data">
                        <div class="col-lg-6">
                        <p>Your administrator user: <strong class="showUsername"><?php echo $_SESSION['username'];?></strong></p>
                         <p>Your administrator password: <strong class="showPassword"><?php echo $_SESSION['password'];?></strong></p>

                         <p>
                         <span style="color:#F21115;">You should remove install folder</span>
                         </p>
                        </div>

                        <div class="col-lg-12 text-right" style="margin-top:10px;">
                          <a class="btn btn-primary Urlsite" href="<?php echo $_SESSION['siteurl'];?>admincp">Go to Admicp</a>
                          <a class="btn btn-info Urlfontend" href="<?php echo $_SESSION['siteurl'];?>">Go to Frontend</a>

                        </div>

                        </form>

                    </div>


                  </div>
                </div> 
              </div>


           </div>



        </div>

    </div>
  </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="js/bootstrap.min.js"></script>
	      <script src="js/custom.js"></script>
  
  </body>
</html>
