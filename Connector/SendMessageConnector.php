<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->member);
    require_once($objectPath->chatroom);
    require_once($objectPath->chatRecord);

    $chatroomID=$_REQUEST["chatroomID"];
    $content=$_REQUEST["content"];
    $sendMID=$_REQUEST["sendMID"];

    $chatRecord=new ChatRecord();
    $chatRecord->crID=$chatroomID;
    $chatRecord->content=$content;
    $chatRecord->sendMID=$sendMID;
    $chatRecord->insert();
    
    //echo("發送訊息成功");
    $chatRecord->sendTime=date("Y-m-j H:i:s");

    echo(json_encode($chatRecord));

?>