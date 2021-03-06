<?php session_start(); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/constants.php"); ?>
<?php include("includes/checksession.php"); ?>

<?php

if(isset($_POST['submit']) && isset($_POST['password'])){
    $pwd = md5($_POST['password']);
    if($pwd == getpasswordbyid($_SESSION['user'], $connection)){
        redirect_to("dashboard.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from bucketadmin.themebucket.net/lock_screen.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 31 Jul 2014 11:14:14 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.html">

    <title>Lock Screen</title>

    <!-- Bootstrap core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="css/stylec4ca.css?1" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="lock-screen" onload="startTime()">

    <div class="lock-wrapper">

        <div id="time"></div>


        <div class="lock-box text-center">
            <div class="lock-name"><?php echo getnamebyid($_SESSION['user'], $connection) ?></div>
            <img src="images/lock_thumb.jpg" alt="lock avatar"/>
            <div class="lock-pwd">
                <form role="form" class="form-inline" action="#" method="post">
                    <div class="form-group">
                        <input type="password" placeholder="Password" name="password" id="exampleInputPassword2" class="form-control lock-input">
                        <button class="btn btn-lock" name="submit" type="submit">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
        function startTime()
        {
            var today=new Date();
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();
            // add a zero in front of numbers<10
            m=checkTime(m);
            s=checkTime(s);
            document.getElementById('time').innerHTML=h+":"+m+":"+s;
            t=setTimeout(function(){startTime()},500);
        }

        function checkTime(i)
        {
            if (i<10)
            {
                i="0" + i;
            }
            return i;
        }
    </script>
</body>

<!-- Mirrored from bucketadmin.themebucket.net/lock_screen.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 31 Jul 2014 11:14:15 GMT -->
</html>
<?php require_once("includes/footer.php"); ?>