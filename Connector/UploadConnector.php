<?php

    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->gallery);
    require_once($objectPath->product);
    require_once($objectPath->commission);
    require_once($modelPath->userDataModel);
    require_once($objectPath->tag);
    require_once($objectPath->gTag);
    require_once($objectPath->pTag);
    require_once($objectPath->cTag);
    require_once($objectPath->sql);

    session_start();

    $userDataModel=new UserDataModel($_SESSION["memberID"]);
    
    

    $mID = $_SESSION["memberID"];

    //判斷類型 設定資料
    switch($_REQUEST["uploadType"]){

        case "gallery":
            $uploadData=new Gallery();
            $uploadData->info=$_REQUEST["uploadDescription"];
            $userDataModel->changePathToGallery();

            break;

        case "product":
            $uploadData=new Product();
            //測試
            $uploadData->price=$_REQUEST["uploadPrice"];
            $uploadData->content=$_REQUEST["uploadDescription"];
            $userDataModel->changePathToProduct();
            break;

        case "commission":
            $uploadData=new Commission();
            $uploadData->content=$_REQUEST["uploadDescription"];
            $userDataModel->changePathToCommission();
            break;
    }

    //設定上傳者資料
   
    $uploadData->mID = $mID;
    $uploadData->title=$_REQUEST["uploadTitle"];
    //$uploadData->content=$_REQUEST["uploadDescription"];

    
    //檔案有傳過來
    if(isset($_FILES["file-upload1"])){

        $uploadPath= $userDataModel->getPath(). "/" . $_FILES["file-upload1"]["name"];
        //echo($uploadPath);

        //copy($_FILES["file-upload1"]["tmp_name"] , "C:/xampp/a.jpg");
        
        if(copy($_FILES["file-upload1"]["tmp_name"] , "../". $uploadPath)){
            echo("上傳檔案成功!");
            //存進資料庫
            // $gallery=new Gallery();
            // $gallery->mID="brian60814@gmail.com";
            // $gallery->title="上傳測試";
            // $gallery->link=$uploadPath;
            // $gallery->insert();
            $uploadData->link=$uploadPath;
            $uploadData->insert();
        }
        else{
            echo("上傳檔案失敗");
        }
    }

    
?>