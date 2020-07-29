<?php
session_start();
if(isset($_SESSION['user'])){
 //   if($_SESSION['role'] === "2")
       header("Location: index.php");
 //   else
 //   header("Location: home");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Sign In | Health commodities logistics and reporting system</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <style type="text/css">
        .error-empty{
            background: #fffbe5 !important;
        }
    </style>
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);"><b>HCLRS</b></a>
            <small>LMCU Database and reporting system</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" method="POST">
                    <div class="msg">Sign in to start your session</div>
                    <p class="error-log"></p>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="user" id="user" placeholder="Email/Phone" autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="pass" id="pass" placeholder="Password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect sign-in" type="button">SIGN IN</button>
                        </div>
                    </div>
                    <div class="row loader" style="position: relative; min-height: 50px">
                        
                    </div>
                    </div>
                </form>
            </div>
        </div>
                    <div class="legal-copy">
                <div class="copyright">
                    &copy; 2019 <a href="javascript:void(0);" class="col-white"><b>HoopNg</b></a>
                    <b>Version: </b> 1.0.1
                </div>
            </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <!--<script src="js/pages/examples/sign-in.js"></script>-->
    <script type="text/javascript">

        $('input').keydown(function(){
            $(this).removeClass('error-empty');
            $('.error-log').removeClass("alert alert-danger alert-warning").empty();
        });


function xhrError($this){

const error_notice = "<b>Notice</b>:";
                    
const error_warning = "<b>Warning</b>:";
                    
const error_fatal = "<b>Fatal error</b>:";
                    
const error_parse = "<b>Parse error</b>:";

  if($this.indexOf(error_fatal) > 0 || $this.indexOf(error_warning) > 0 || $this.indexOf(error_notice) > 0 || $this.indexOf(error_parse) > 0)
    return 404;
  else 
    return 200;
}

    $('.sign-in').click(function(e){
       // e.preventDefault();

        var user = $('#user').val();
        var pass = $('#pass').val();
        if(user === "" && pass !== ""){
            $('#user').focus().addClass('error-empty');
            $('.error-log').addClass('alert alert-warning').text("You cannot leave email/phone field empty");
            return;
        }

        if(pass === "" && user !== ""){
             $('#pass').focus().addClass('error-empty');
            $('.error-log').addClass('alert alert-warning').text("You cannot leave password field empty");
             return;
        }

        if(pass === "" && user === ""){
            $('input').addClass('error-empty');
            $('.error-log').addClass('alert alert-warning').text("You cannot leave email/phone and password field empty");
            return;
        }
        else{
        $('.loader').html('<div class="loader" style="text-align:center;"><div class="preloader"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div><p style="text-align:center;">Please wait...</p></div>');
        
        $.post("sign-in.php", {user: user, pass: pass}, function(data){
            if(xhrError(data) !== 404){
            if(data === "404"){
                $('.error-log').addClass('alert alert-danger').text("Wrong email/phone and password!");
                $('.loader').empty();
            }
            else{
                $('.loader').empty();
                localStorage.setItem("logged", data);
                window.location.assign("home");
            }
        }
        else{
            $('.error-log').addClass('alert alert-danger').text("Database connection error");
            console.log(data);
                $('.loader').empty();
            }
        })
    }
    });
    </script>
</body>

</html>