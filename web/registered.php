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
    <script src="javascript/registered.js"></script>
    <script src="javascript/memberDataChecking.js"></script>
    <!--sweetalert-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
        require_once("../Path.php");
        require_once($viewPath->registeredView);
        $registeredView = new RegisteredView();
    ?>
</head>

<body class="signbg">

    <div class="signNavBarContainer">
        <div class="signlogo">
            <a href="index.html">
                <img src="images/logo_static.png">
            </a>
        </div>
        <!--老師說要拿掉
        <div class="signmenu">
            <img src="images/shopcart.png">
            <img src="images/user.png">
        </div>
        -->
        <div class="clear"></div>
    </div>

    <div class="signContent">
        <div class="whitebackground2 registerWb">
            <!--這是專門放白色背景的DIV-->
            <div class="joinus">
                <img src="images/joinus.png">
            </div>

            <form id="memberForm" action="registered.php" method="POST">
                <div class="infoitem">
                    <input type="email" id="account" name="account" class="registerAccount" placeholder="電子郵件">

                </div>

                <div class="infoitem">
                    <input type="text" id="userName" name="userName" class="registerAccount" placeholder="使用者名稱">

                </div>

                <div class="infoitem">
                    <input type="password" id="password" name="password" class="registerAccount" placeholder="密碼">

                </div>

                <div class="infoitem">
                    <input type="password" id="confirmPassword" name="confirmPassword" class="registerAccount" placeholder="再輸入一次密碼">

                </div>

                <div class="actionitem">
                    <button id="registeredButton"  class="signbutton"><img src="images/registeredbutton.png"></button>
                </div>
            </form>



        </div>
    </div>



</body>

</html>