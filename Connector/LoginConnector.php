<?php

    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->member);

    //測試
    $data=array();

    session_start();
    if(isset($_SESSION["memberID"])){
        $data["isLogin"]=true;
        $data["memberID"]=$_SESSION["memberID"];
        $member=new Member();
        $member->load($_SESSION["memberID"]);
        $data["member"]=$member;

    }
    else{
        // $webPath=new WebPath();
        // $webPath->location();
        // header($webPath->sign);
        $data["isLogin"]=false;
    }

    echo(json_encode($data));
?>