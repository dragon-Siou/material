<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->gallery);
    require_once($objectPath->product);
    require_once($objectPath->commission);

    $type=$_REQUEST["type"];
    $id=$_REQUEST["id"];

    $data;

    switch($type){
        case "gallery":
            $data=new Gallery();
            //我需要資料啦幹
            $data->load($id);
            echo("刪除作品成功");
            $data->delete();


            break;

        case "product":
            $data=new Product();
            $data->load($id);
            $data->setEnable(false);
            $data->update();
            echo("刪除商品成功");


            break;

        case "commission":
            $data=new Commission();
            $data->load($id);
            $data->delete();
            echo("刪除委託成功");

            

            break;
    }

    //刪除檔案
    unlink( "../" . $data->link);
    

?>