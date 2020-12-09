<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->member);
    require_once($objectPath->sql);
    require_once($modelPath->userDataModel);

    $member=new Member();
    $member->load($_REQUEST["mID"]);
    $member->userName=$_REQUEST["userName"];
    $member->profile=$_REQUEST["profile"];

    $userDataModel=new UserDataModel($_REQUEST["mID"]);

    //有檔案
    //頭貼
    if(isset($_FILES["file-upload"]) && !empty($_FILES["file-upload"]["tmp_name"]) ){
        $uploadPath= $userDataModel->getPath(). "/" . $_FILES["file-upload"]["name"];
    
        if(copy($_FILES["file-upload"]["tmp_name"] , "../". $uploadPath)){
            echo("上傳檔案成功!");
            //刪除舊的
            unlink("../" . $member->pLink);
            $member->pLink=$uploadPath;
        }

        
    }

    $member->update();

?>