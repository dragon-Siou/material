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

    require_once($objectPath->gLike);
    require_once($listPath->likeList);

    require_once($objectPath->sql);

    session_start();

    $data=array();


    $memberID="";
    if(isset($_SESSION["memberID"])){
        $memberID=$_SESSION["memberID"];
    }
    

    //傳過來的itemID跟type
    $itemID=$_REQUEST["itemID"];
    $showDataType=$_REQUEST["showDataType"];

    //留言
    $commentList=new CommentList();

    //tags
    $tagList=new TagList();

    //會員
    $member=new Member();

    //拿資料
    switch($showDataType){
        //是作品才有留言
       
        case "gallery":
            
            $gallery=new Gallery();
            $gallery->load($itemID);
            $data["showData"]=$gallery;
            $commentList->loadFromGallery($itemID);

            //tag
            
            $tagList->loadFromGallery($itemID);

            //使用者資料
            if(!empty($memberID)){
                $user=new Member();
                $user->load($memberID);
                $data["pLink"]=$user->pLink;
            }
            else{
                $data["pLink"]="web/images/default_pic.png";
            }

            //按讚
            $gLike=new GLike();
            $gLike->mID=$memberID;
            $gLike->gID=$itemID;

            //判斷使用者有沒有按過讚
            if($gLike->isExist()){
                $data["isLike"]=true;
            }
            else{
                $data["isLike"]=false;
            }

            //讚數
            $likeList=new LikeList();
            $likeList->loadFromGID($itemID);
            $data["likeCount"]=$likeList->count;

            //會員
            $member->load($gallery->mID);
            $data["userName"]=$member->userName;
            $data["member"]=$member;

            break;

        case "product":

            $product=new Product();
            $product->load($itemID);
            $data["showData"]=$product;
            //tag
            $tagList->loadFromProduct($itemID);

            
            //會員
            $member->load($product->mID);
            $data["userName"]=$member->userName;
            $data["member"]=$member;

            break;

        case "commission":

            $commission=new Commission();
            $commission->load($itemID);
            $data["showData"]=$commission;
            //tag
            $tagList->loadFromCommission($itemID);

            
            //會員
            $member->load($commission->mID);
            $data["userName"]=$member->userName;
            $data["member"]=$member;

            break;
    
    }

    $data["tags"]= $tagList->data;
    $data["comments"]=$commentList->data;
    



    // $data["ID"]=$_REQUEST["ID"];
    // $data["type"]=$_REQUEST["type"];

    echo(json_encode($data));
?>