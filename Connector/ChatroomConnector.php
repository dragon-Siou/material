<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->member);
    require_once($objectPath->chatroom);
    require_once($listPath->chatroomList);
    require_once($objectPath->chatRecord);
    require_once($listPath->chatRecordList);
    require_once($objectPath->sql);

    //要資料
    $memberID=$_REQUEST["memberID"];

    $chatroomList=new ChatroomList();
    $chatroomList->loadFromMember($memberID);

    //$data=$chatroomList->data;
    $data=array();
    //製作資料
    $i=0;
    foreach($chatroomList->data as $chatroom){

        $data[$i]["chatroom"]=$chatroom;

        $member=new Member();
        $member->load($chatroom->mID2);
        $data[$i]["member"]=$member;

        //最新訊息
        $chatRecordList=new ChatRecordList();
        $chatRecordList->loadNewFromChatroom($chatroom->crID);

        //不一定有
        if(isset($chatRecordList->data[0])){
            $data[$i]["newChatRecord"]
            =$chatRecordList->data[0];
        }
        else{
            $data[$i]["newChatRecord"]=new ChatRecord();
            $data[$i]["newChatRecord"]->content="";
        }

        //第一筆
        // if($i == 0){
        //     $data["firstChatID"]=$chatroom->mID2;
        // }

        $i++;
    }

    echo(json_encode($data));
?>