<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->comment);
    require_once($objectPath->member);
    require_once($objectPath->sql);



    $commentContent=$_REQUEST["commentContent"];
    $mID=$_REQUEST["mID"];
    $gID=$_REQUEST["gID"];

    $comment=new Comment();
    $comment->gID=$gID;
    $comment->mID=$mID;
    $comment->content=$commentContent;
    $comment->insert();

    $member=new Member();
    $member->load($mID);

    //$data["isSuccess"]=true;

    $data=array();
    //回傳留言的資料
    $data["name"]=$member->userName;
    $data["content"]=$commentContent;
    $data["time"]=date("Y-m-j H:i:s");
    $data["pLink"]=$member->pLink;


    echo(json_encode($data));

?>