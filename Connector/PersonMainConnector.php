<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->gallery);
    require_once($objectPath->product);
    require_once($objectPath->commission);

    require_once($listPath->commentList);
    require_once($objectPath->member);
    require_once($modelPath->userDataModel);
    require_once($modelPath->loadDataModel);

    require_once($listPath->tagList);
    require_once($objectPath->cTag);
    require_once($objectPath->gTag);
    require_once($objectPath->pTag);
    require_once($objectPath->tag);

    require_once($objectPath->sql);

    $data=array();

    //session_start();

    //負責要person的資料
    $memberID=$_REQUEST["pageMID"];
    //$memberID="nieu.hsuan@gmail.com";
    
    if(isset($_REQUEST["showDataType"])){
        //
        $loadDataModel=new LoadDataModel($_REQUEST["showDataType"]);
        $loadDataModel->loadFromMember($memberID);
        $data=$loadDataModel->data;
        /*
        //繼續附加資料
        for($i=0; $i<=count($loadDataModel->data)-1 ;$i++){
            //要會員的姓名

            $data[$i]["showData"]=$loadDataModel->data[$i];

            $member=new Member();
            $member->load($memberID);

            $data[$i]["userName"]=$member->userName;
            
            //留言
            $commentList=new CommentList();

            //ID
            $ID=$loadDataModel->data[$i]->ID;

            //tags
            $tagList=new TagList();

            $dataType=$loadDataModel->dataType;

            //是作品才有留言
            switch($dataType){

                case "gallery":
                    
                    $commentList->loadFromGallery($ID);

                    //tag
                    
                    $tagList->loadFromGallery($ID);

                    break;
    
                case "product":

                    //tag
                    $tagList->loadFromProduct($ID);

                    break;
    
                case "commission":

                    //tag
                    $tagList->loadFromCommission($ID);

                    break;
            }


            //$commentList->loadFromGallery("brian60814@gmail.com");
            $data[$i]["tags"]= $tagList->data;
            $data[$i]["comments"]=$commentList->data;


            //tag
        }*/

    }

    echo(json_encode($data));

?>