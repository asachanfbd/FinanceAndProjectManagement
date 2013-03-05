<?php
  require_once("lib/library.php");
  if($user->iflogin()){
      header("Location: index.php");
  }
 ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
        body{
            margin: 0 auto;
            background-position: -413px -69px;
        }
        input:focus,
        select:focus,
        textarea:focus,
        button:focus {
            outline: none;
            background: #fff;
        }
            .login_main{
                width: 850px;
                font-family: verdana;
                font-size: small;
                margin: 0 auto;
            }
            .login_main .login_body{
                width: 100%;
                overflow: auto;
                color: #34363d;
            }
            .login_main .login_body .login_body_info{
                width: 45%;
                padding: 1%;
                float: right;
                margin-top: 50px;
            }
            .login_main .login_body .login_body_info .info{
                margin: 0.1%;
            }
            .login_main .login_body_form{
                margin: 2% 1%;
                margin-top: 100px;
                padding: 1%;
                width: 40%;
                float: left;
            }
            .login_main .login_footer{
                margin: 0.1%;
                width: 100%;
            }
            .input{
                width: 100%;
                margin: 0.5% 0 1.5% 0;
                border: 1px solid #000;
            }
            .input input{
                margin: 2% 3%;
                border: none;
                width: 90%;
            }
            .button{
                float: left;
                font-weight: bold;
            }
            .button>input{
                background-color: #51bcea;
                display: block;
                text-decoration: none;
                color: #fff;
                padding: 7% 20%;
                text-align: center;
                border:none;
                cursor: pointer;
            }
            .button>input:hover{
                background-color: #313131;
            }
            .check{
                float: left;
                clear: right;
                padding: 0.4%;
                margin: 0.5% 0 0 1%;
            }
            .check input{
                height: 10px;
            }
            .lower{
                clear:both;
                margin: 5% 0 1.2% 0;
                font-size: 11px;
            }
            .lower>a{
                text-decoration: none;
                color: #2672ec;
            }
            .lower>a:hover{
                text-decoration: underline;
            }
            .top_form{
                overflow: auto;
                font-size: 15px;
            }
            .top_form>div:first-child{
                float: left;
            }
            .top_form>div:nth-child(even){
            }
            .features{
                list-style-type: none;
                padding-left: 0px;
                overflow: auto;
            }
            .features>li{
                width: 52%;
                float: left;
                margin: 5px 0px;
                overflow: auto;
            }
            .features>li>img{
                float: left;
            }
            .title{
                float: left;
                margin: 6px 0px 10px 6px;
            }
            .title>p:first-child{
                margin: 0px;
                font-weight: bold;
            }
            .title>p:nth-child(even){
                margin: 0px;
            }
            .main_container{
                margin: 14px;
            }
            .learn{
                float: left;
                font-size: 11px;
                margin-top: 27px;
            }
            .learn>a{
                color: #51BCEA;
                text-decoration: none;
            }
            .learn>a:hover{
                text-decoration: underline;
            }
            .ots_link{
                list-style-type: none;
                padding-left: 0px;
                font-size: 11px;
                margin-top: 30px;
            }
            .ots_link>li{
                float: left;
            }
            .ots_link>li>a{
                text-decoration: none;
                margin-right: 13px;
                color: #51bcea;
            }
            .ots_link>li>a:hover{
                text-decoration: underline;
            }
            #footer_div{
                margin-top: 25px;
                color: #34363d;
                letter-spacing: 1px;
                border-top: 1px solid #51bcea;
            }
            #footer_div>div{
                margin-top: 10px;
                overflow: auto;
            }
            #footer_div div>div{
                float:left;
                color: #34363d;
                padding: 6px 1px;
                margin: 0px;
                font-size: 12px;
            }
            #footer_div div>a:hover{
                color:#51bcea;
                text-decoration: underline;
            }
            #footer_div div>a{
                text-decoration: none;
                 color:#555;
                 font-size: 11px;
            }
            input[type=text], input[type=password]{
                padding: 7px;
                border: 1px solid #000;
                margin: 5px 0;
                width: 90%;
            }
            input[type=text]:focus, input[type=password]:focus{
                border: 1px solid #3792EC;
                background: #F3FAFE;
            }
            .logo{
                max-height: 100px;
                max-width: 320px;
            }
        </style>
        <title>
            Login | Coravity Management
        </title>
    </head>
<body>
    <div class="login_main">
        <div class="login_body">
             <div class="login_body_form">
                 <img src="images/logofinal.png" alt="Coravity Infotech" class="logo">
                 <div id="error" style="color: red; margin-top: 30px;">
                    <?php
                        if(isset($_GET['error'])){
                            echo $_GET['error'];
                        }else{
                            echo '&nbsp';
                        }
                    ?>
                </div>
                 <form method="POST" action="auth.php" class="ots_form">
                 <input type="hidden" id="loginsubmitform" name="loginsubmitform" value="true">
                        <div><input type="text" name="username" id="username" placeholder="User Name"/></div>
                        <div><input type="password" name="password" id="password" placeholder="Password"/></div>
                        <div style="overflow: auto; margin-top: 10px;">
                            <div class="button"><input type="submit" name="signin" value="Sign-In"></div>
                        </div>
                 </form>
                 <div class="lower">
                    <a href="forgotpass.php">Can't Access your Account?</a>
                 </div>
             </div>
             <div class="login_body_info">
                 <div class="info">
                      <img src="images/login-image.png" >
                 </div>
             </div>
        </div>
        <div id="footer_div">
            <div>
                <div>&copy; Copyright 2012 Bitumode.</div>
                <div style="float: right;">Powered By <a href="http://www.coravity.com" target="_blank">Coravity Infotech</a></div>       
            </div>
        </div>
    </div>
</body>
</html>