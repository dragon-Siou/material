<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->track);

    $isTrack=$_REQUEST["isTrack"];

    $trackID=$_REQUEST["trackID"];

    session_start();
    $mID=$_SESSION["memberID"];

    //echo(gettype( $_REQUEST["isTrack"]));
    //有追蹤
    //刪掉
    if($isTrack == "true"){
        $track= new Track();
        $track->mID=$mID;
        $track->trackID=$trackID;
        $track->delete();
        echo("取消追蹤");
    }
    //沒有追蹤
    //增加
    else{
        $track= new Track();
        $track->mID=$mID;
        $track->trackID=$trackID;
        $track->insert();
        echo("增加追蹤");
    }

?>