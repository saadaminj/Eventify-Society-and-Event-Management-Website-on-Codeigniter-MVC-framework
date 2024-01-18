<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Sign In | CBSPD Exam</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo SITE_URL.'/assets/admin/';?>favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo SITE_URL.'/assets/admin/';?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo SITE_URL.'/assets/admin/';?>plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo SITE_URL.'/assets/admin/';?>plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo SITE_URL.'/assets/admin/';?>css/style.css" rel="stylesheet">
</head>

<body class="login-page">
<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);">Admin <b>CBSPD Exam</b></a>
        <!-- <small>CBSDT | Admin</small> -->
    </div>
    <div class="card">
        <div class="body">
            <form id="sign_in" method="POST" action="<?php echo SITE_ADMIN_URL.'admin_users_admin/login';?>">
                <div class="msg">Sign in to start your session</div>
                <?php if(isset($error)){ ?>
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>oops!</strong> <?php echo $error;?>
                    </div>
                <?php }?>
                <?php if(isset($validation_errors)){?>
                        <div class="alert alert-danger alert-dismissable fade in">
                            <a href="javascript:;" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>oops!</strong> <?php echo validation_errors();?>
                        </div>
                <?php } ?>
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                    <div class="form-line">
                        <input type="text" class="form-control" name="user_name" placeholder="User name" required autofocus >
                    </div>
                </div>
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="password" placeholder="Password" required autofocus >
                    </div>
                </div>
                <div class="row">
                    <!-- <div class="col-xs-8 p-t-5">
                        <input type="checkbox" name="remember_me" value="1" id="rememberme" class="filled-in chk-col-pink">
                        <label for="rememberme">Remember Me</label>
                    </div> -->
                    <div class="col-xs-4">
                        <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                    </div>
                </div>
                <!-- <div class="row m-t-15 m-b--20">
                    <div class="col-xs-6">
                        <a href="sign-up.html">Register Now!</a>
                    </div>
                    <div class="col-xs-6 align-right">
                        <a href="forgot-password.html">Forgot Password?</a>
                    </div>
                </div> -->
            </form>
        </div>
    </div>
</div>

<!-- Jquery Core Js -->
<script src="<?php echo SITE_URL.'/assets/admin/';?>plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="<?php echo SITE_URL.'/assets/admin/';?>plugins/bootstrap/js/bootstrap.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="<?php echo SITE_URL.'/assets/admin/';?>plugins/node-waves/waves.js"></script>

<!-- Validation Plugin Js -->
<script src="<?php echo SITE_URL.'/assets/admin/';?>plugins/jquery-validation/jquery.validate.js"></script>

<!-- Custom Js -->
<script src="<?php echo SITE_URL.'/assets/admin/';?>js/admin.js"></script>
<script src="<?php echo SITE_URL.'/assets/admin/';?>js/pages/examples/sign-in.js"></script>
</body>

</html>