<?php
    require_once(dirname(__FILE__)."/../Path.php");

    class PersonController{

        function __construct()
        {
            //測試
            session_start();
            if(isset($_SESSION["memberID"])){
                echo($_SESSION["memberID"]);
            }
            else{
                $webPath=new WebPath();
                $webPath->location();
                header($webPath->sign);
            }
        }
    }

    //echo("路徑測試 ".__FILE__."<br>");
?>