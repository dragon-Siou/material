<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pick a pic</title>
    <link rel="icon" href="https://scontent-tpe1-1.xx.fbcdn.net/v/t1.15752-9/99014266_543009106363583_612886314106224640_n.png?_nc_cat=102&_nc_sid=b96e70&_nc_oc=AQk7csJrcNeIUIxKONwRn1t7Eo1Z53EyeHdIOzbFxdE0qagGFcWXgHpFqvjarYtvuVA&_nc_ht=scontent-tpe1-1.xx&oh=82322943c21d87282a41807cbc256a7b&oe=5EF316B1"
    />
    <link rel=stylesheet type="text/css" href="web.css">
    <link rel=stylesheet type="text/css" href="signAndRegister.css">
    <link rel=stylesheet type="text/css" href="topNavbar.css">
    <script src="jquery-3.5.0.min.js"></script>
    <script src="javascript/sign.js"></script>
    <script src="javascript/memberDataChecking.js"></script>

    <!--sweetalert-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
        require_once("../Path.php");
        require_once($viewPath->signView);
        $signView=new SignView();
    ?>
</head>

<body class="signbg">

    <div class="signNavBarContainer">
        <div class="signlogo">
            <a href="index.html">
                <img src="images/logo_static.png">
            </a>
        </div>

        <div class="clear"></div>
    </div>

    <div class="signContent">
        <div class="whitebackground">
            <!--這是專門放白色背景的DIV-->
            <div class="welcome">
                <img src="images/welcome.png">
            </div>

            <form id="memberForm" action="sign.php" method="POST">
                <div class="infoitem">
                    <input type="text" id="account" name="account" class="account" placeholder="帳號">
                    <img src="images/accounticon.png" class="searchicon">
                </div>

                <div class="infoitem">
                    <input type="password" id="password" name="password" class="account" placeholder="密碼">
                    <img src="images/passwordicon.png" class="searchicon">
                </div>

                <div class="actionitem">
                    <button id="signButton" class="signbutton"><img src="images/loginbutton.png"></button>
                </div>
            </form>

            <div class="actionitem">
                <span>
                        <a href="#">忘記密碼</a>
                    </span>
                <span>
                        <a href="registered.php">還沒註冊?</a>
                    </span>
            </div>

        </div>
    </div>







</body>

</html>