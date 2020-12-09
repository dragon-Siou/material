<?php
    require_once(dirname(__FILE__)."/../Path.php");

    //存session
    session_start();

    $pID=$_REQUEST["pID"];

    //有登入
    if(isset($_SESSION["memberID"])){

        //購物車還未創建的話
        if(!isset($_SESSION["shopCart"])){
            $_SESSION["shopCart"]=array();
        }

        //有加入過購物車
        if(isset($_SESSION["shopCart"][$pID])){
            echo("該商品已加入購物車");
        }
        //還沒加入過
        else{
            //加入
            $_SESSION["shopCart"][$pID] = $pID;
            echo("成功加入購物車!");

        }
    }
    else{
        echo("請先登入");
    }
    
?>