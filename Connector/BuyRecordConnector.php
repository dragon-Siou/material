<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($listPath->transactionList);
    require_once($objectPath->member);
    require_once($objectPath->product);

    session_start();

    $mID=$_SESSION["memberID"];
    $data=array();

    $transactionList=new TransactionList();
    $transactionList->loadFromMember($mID);

    $i=0;
    foreach ($transactionList->data as $transaction) {
        
        $data[$i]["transaction"]=new Transaction();
        $data[$i]["transaction"]=$transaction;
        
        $product=new Product();
        $product->load($transaction->pID);
        $data[$i]["product"]=$product;

        $member=new Member();
        $member->load($product->mID);

        $data[$i]["member"]=$member;

        //echo($data[$i]["transaction"]->tTime);
        $i++;
    }

    echo(json_encode($data));

?>