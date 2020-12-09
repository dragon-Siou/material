<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->member);
    require_once($objectPath->chatroom);
    require_once($listPath->chatroomList);
    require_once($objectPath->chatRecord);
    require_once($listPath->chatRecordList);
    require_once($objectPath->sql);

    $mID=$_REQUEST["mID"];
    $chatID=$_REQUEST["chatID"];

    $chatroom=new Chatroom();
    //如果聊天室本來就存在
    if($chatroom->loadFromMID($mID,$chatID)){
        echo($chatroom->crID);
    }
    else{
        //創建
        $chatroom->mID1=$mID;
        $chatroom->mID2=$chatID;
        $chatroom->insert();
        $chatroom->loadFromMID($mID,$chatID);
        echo($chatroom->crID);
    }
?>