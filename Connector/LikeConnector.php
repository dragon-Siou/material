<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->gLike);
    require_once($listPath->likeList);
    require_once($objectPath->sql);


    session_start();
    $data=array();
    
    $dealType=$_REQUEST["dealType"];
    //有登入
    if(isset($_SESSION["memberID"])){
        $memberID=$_SESSION["memberID"];
        $data["isLogin"]=true;

        $gLike=new GLike();
        $gLike->gID = $_REQUEST["gID"];
        $gLike->mID = $memberID;

        //新增
        if($dealType === "add"){
            $gLike->insert();
        }
        //刪除
        else{
            $gLike->delete();
        }

        //更新
        $likeList=new LikeList();
        $likeList->loadFromGID($_REQUEST["gID"]);
        $data["newLikeCount"] = $likeList->count;
        
    }
    //未登入
    else{
        $data["isLogin"]=false;
    }

    echo(json_encode($data));
    
?>