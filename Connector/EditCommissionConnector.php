<?php
require_once(dirname(__FILE__)."/../Path.php");
require_once($objectPath->commission);
require_once($listPath->cTagList);
require_once($objectPath->cTag);
require_once($objectPath->tag);

require_once($objectPath->sql);

$data=array();

$data["editTitle"]=$_REQUEST["editTitle"];
$data["editDescription"]=$_REQUEST["editDescription"];


$cID=$_REQUEST["cID"];
//舊的tag先刪
$cTagList=new CTagList();
$cTagList->loadFromCommission($cID);
$cTagList->deleteAll();


//echo($gID);
//修改title跟content
$commission=new Commission();
$commission->load($cID);

$commission->title= $data["editTitle"];
$commission->content=$data["editDescription"];
// echo($gallery->title);
// echo($gallery->gID);
// echo($gallery->info);
// echo($gallery->link);
$commission->update();

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
        $cTag=new CTag();
        $cTag->cID=$cID;
        $cTag->tName=$tName;
        $cTag->insert();
    }
}




//echo(json_encode($data));
?>