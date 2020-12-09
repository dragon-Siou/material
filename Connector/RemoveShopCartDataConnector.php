<?php
    require_once(dirname(__FILE__)."/../Path.php");

    session_start();

    $pID=$_REQUEST["pID"];

    unset($_SESSION["shopCart"][$pID]);

    echo("移除成功");
?>