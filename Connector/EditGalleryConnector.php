<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->gallery);
    require_once($listPath->gTagList);
    require_once($objectPath->gTag);
    require_once($objectPath->tag);
    
    require_once($objectPath->sql);

    $data=array();

    $data["editTitle"]=$_REQUEST["editTitle"];
    $data["editDescription"]=$_REQUEST["editDescription"];

    
    $gID=$_REQUEST["gID"];
    //舊的tag先刪
    $gTagList=new GTagList();
    $gTagList->loadFromGallery($gID);
    $gTagList->deleteAll();


    //echo($gID);
    //修改title跟content
    $gallery=new Gallery();
    $gallery->load($gID);
    
    $gallery->title= $data["editTitle"];
    $gallery->info=$data["editDescription"];
    // echo($gallery->title);
    // echo($gallery->gID);
    // echo($gallery->info);
    // echo($gallery->link);
    $gallery->update();

    //把#拿掉
    //把tag加入資料庫
    //確定有tag
    if(isset($_REQUEST["editTags"])){
        $data["editTags"]=$_REQUEST["editTags"];
        for($i = 0 ; $i <= count( $data["editTags"])-1 ; $i++){
            $data["editTags"][$i] = substr($data["editTags"][$i],1);
            $tName=$data["editTags"][$i];

            //先檢查tag有沒有存在
            $tag=new Tag();
            //不存在要新增
            if(!$tag->load($tName)){
                $tag->tName=$tName;
                $tag->insert();
            }

            //新增tag
            $gTag=new GTag();
            $gTag->gID=$gID;
            $gTag->tName=$tName;
            $gTag->insert();
        }
    }




    //echo(json_encode($data));
?>