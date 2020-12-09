<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->product);
    require_once($objectPath->member);
    
    session_start();

    $data=array();

    $i=0;
    foreach ($_SESSION["shopCart"] as $key => $value) {
        $product=new Product();
        $product->load($key);
        
        $data[$i]["showData"]=$product;

        $member=new Member();
        $member->load($product->mID);

        $data[$i]["userName"]=$member->userName;
        $data[$i]["member"]=$member;

        $i++;
    }

    echo(json_encode($data));

?>