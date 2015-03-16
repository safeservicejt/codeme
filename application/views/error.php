<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Noblesse CMS">
    <title>Error report</title>
    <link href="{{ROOT_URL}}bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
 

    <style>
    body
    {
        background-color: #5094DE;
        color:#ffffff;
    }

    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row" style="margin-top:100px;">
        <div class="col-lg-12 text-center" style="text-align:center;">
            <img src="{{ROOT_URL}}bootstrap/images/error.png" />
        </div>
        <div class="col-lg-12 text-center">
           <p style="text-align:center;">
            {{report}}               
           </p>
        </div>

    </div>
</div>



</body>
</html>
