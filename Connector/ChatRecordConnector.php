<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->member);
    require_once($objectPath->chatroom);
    require_once($listPath->chatroomList);
    require_once($objectPath->chatRecord);
    require_once($listPath->chatRecordList);
    require_once($objectPath->sql);

    $chatroomID=$_REQUEST["chatroomID"];
    $chatID=$_REQUEST["chatID"];

    $chatRecordList=new ChatRecordList();
    $chatRecordList->loadFromChatroom($chatroomID);

    $member=new Member();
    $member->load($chatID);


    $data=array();
    $data["showData"]=$chatRecordList->data;
    $data["chatMember"]=$member;

    echo(json_encode($data));

?>