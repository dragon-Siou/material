<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->track);

    session_start();

    $trackID=$_REQUEST["trackID"];
    

    //$data=array();

    //有登入
    if(isset($_SESSION["memberID"])){
        $mID=$_SESSION["memberID"];

        $data["isLogin"]=true;
        //有沒有追蹤
        $track=new Track();
        //存在
        if($track->load($mID,$trackID)){
            $data["isTrack"]=true;
        }
        else{
            $data["isTrack"]=false;
        }

    }
    else{
        $data["isLogin"]=false;
    }

    echo(json_encode($data));

?>