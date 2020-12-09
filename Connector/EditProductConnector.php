<?php
    require_once(dirname(__FILE__)."/../Path.php");

    require_once($objectPath->product);
    require_once($listPath->pTagList);
    require_once($objectPath->pTag);
    require_once($objectPath->tag);
    
    require_once($objectPath->sql);

    $data=array();

    $data["editTitle"]=$_REQUEST["editTitle"];
    $data["editDescription"]=$_REQUEST["editDescription"];
    $data["editPrice"]=$_REQUEST["editPrice"];

    $pID=$_REQUEST["pID"];
    //舊的tag先刪
    $pTagList=new PTagList();
    $pTagList->loadFromProduct($pID);
    $pTagList->deleteAll();

    //修改title跟content
    $product=new Product();
    $product->load($pID);

    $product->title=$data["editTitle"];
    $product->content=$data["editDescription"];
    $product->price=$data["editPrice"];

    $product->update();

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
            $pTag=new PTag();
            $pTag->pID=$pID;
            $pTag->tName=$tName;
            $pTag->insert();
        }
    }
?>