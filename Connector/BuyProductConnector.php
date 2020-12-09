<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->product);
    require_once($objectPath->transaction);

    session_start();

    $mID=$_SESSION["memberID"];

    //產生交易紀錄
    //可以跟session拿
    if(isset($_SESSION["shopCart"])){
        foreach ($_SESSION["shopCart"] as $key => $value) {
            $product=new Product();
            $product->load($key);

            $transaction=new Transaction();
            $transaction->mID=$mID;
            $transaction->pID=$key;
            $transaction->price=$product->price;
            $transaction->insert();
        }

        //刪除所有的session
        unset($_SESSION["shopCart"]);
        echo("購買成功");
    }
    else{
        echo("您尚未選擇商品");
    }


    

    
?>