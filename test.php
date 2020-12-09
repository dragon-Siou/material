<?php

require_once("./Path.php");
require_once($modelPath->userDataModel);
/*
    $input = "this @isateting";
    $cleaned = preg_match("/[^ \w @ ]/", $input);
     
    echo $cleaned;*/
    
    $userDataModel=new UserDataModel("brian60814@gmail.com");
    $userDataModel->changePathToGallery();
    

    if(isset($_FILES["file1"])){
        if(copy($_FILES["file1"]["tmp_name"] , $userDataModel->getPath()."/" . $_FILES["file1"]["name"])){
            echo("上傳檔案成功!");
        }
        else{
            echo("檔案上傳失敗");
        }
    }
    else{
        echo("沒有資料");
    }
    //echo("跳轉");
?>