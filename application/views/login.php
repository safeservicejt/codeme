<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>Login Page</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo ROOT_URL; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="<?php echo ROOT_URL; ?>bootstrap/css/flat-theme.css" rel="stylesheet">

    <link href="<?php echo ROOT_URL; ?>bootstrap/css/custom.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="<?php echo ROOT_URL; ?>bootstrap/js/jquery-2.0.0.min.js"></script>
    <script src="<?php echo ROOT_URL; ?>bootstrap/js/jquery.min.map"></script>

    <script src="<?php echo ROOT_URL; ?>bootstrap/js/custom.js"></script>

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-lg-5 col-lg-offset-3">
            <h3>Login</h3>

            <?php echo $alert; ?>

            <form action="" method="post" enctype="multipart/form-data">
                <p>
                    <input type="text" class="form-control" name="username" placeholder="Username..."/>

                </p>

                <p>
                    <input type="password" class="form-control" name="password" placeholder="Password..."/>

                </p>

                <p>
                    <button type="submit" name="btnLogin" class="btn btn-success">Login</button>

                </p>


            </form>
        </div>
    </div>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script src="<?php echo ROOT_URL; ?>boostrap/js/bootstrap.min.js"></script>

</body>
</html>
