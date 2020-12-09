<?php

    class ObjectPath{

        public $chatRecord;
        public $chatroom;
        public $comment;
        public $commission;
        public $cTag;
        public $gallery;
        public $gTag;
        public $member;
        public $product;
        public $pTag;
        public $sql;
        public $tag;
        public $track;
        public $transaction;
        public $gLike;

        public function __construct()
        {
            $path=dirname(__FILE__)."/Object/";
            $this->chatRecord= $path."ChatRecord.php";
            $this->chatroom= $path."Chatroom.php";
            $this->comment= $path."comment.php";
            $this->commission= $path."Commission.php";
            $this->cTag= $path."CTag.php";
            $this->gallery= $path."Gallery.php";
            $this->gTag= $path."GTag.php";
            $this->member= $path."Member.php";
            $this->product= $path."Product.php";
            $this->pTag= $path."PTag.php";
            $this->sql= $path."sql.php";
            $this->tag= $path."Tag.php";
            $this->track= $path."Track.php";
            $this->transaction= $path."Transaction.php";
            $this->gLike=$path."GLike.php";
            
        }
    }

    class ListPath{
        public $memberList;
        public $galleryList;
        public $commissionList;
        public $productList;
        public $commentList;
        public $chatroomList;
        public $chatRecordList;
        public $tagList;
        public $likeList;
        public $gTagList;
        public $pTagList;
        public $cTagList;
        public $transactionList;
        public $trackList;

        public function __construct()
        {
            $path=dirname(__FILE__)."/List/";
            $this->memberList=$path."MemberList.php";
            $this->galleryList=$path."GalleryList.php";
            $this->commissionList=$path."CommissionList.php";
            $this->productList=$path."ProductList.php";
            $this->commentList=$path."CommentList.php";
            $this->chatroomList=$path."ChatroomList.php";
            $this->chatRecordList=$path."ChatRecordList.php";
            $this->tagList=$path."TagList.php";
            $this->likeList = $path."LikeList.php";
            $this->gTagList = $path."GTagList.php";
            $this->pTagList = $path."PTagList.php";
            $this->transactionList = $path . "TransactionList.php";
            $this->cTagList= $path. "CTagList.php";
            $this->trackList=$path. "TrackList.php";
        }
    }

    class WebPath{
        
        private $path;

        public $registered;
        public $index;
        public $person;
        public $sign;

        public function __construct()
        {
            $path=dirname(__FILE__)."/web/";
            $this->setPath();
        }

        private function setPath(){
            $this->registered=$this->path."registered.html";
            $this->index=$this->path."index.html";
            $this->person=$this->path."person.php";
            $this->sign=$this->path."sign.php";
        }

        public function location(){
            $host  = $_SERVER['HTTP_HOST'];
            $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            //$extra = 'web/index.html';
            $this->path="Location: http://{$host}{$uri}/";
            $this->setPath();
        }
    }

    class ModelPath{
        public $userDataModel;
        public $registeredModel;
        public $signModel;
        public $loadDataModel;

        public function __construct()
        {
            $path=dirname(__FILE__)."/Model/";
            $this->userDataModel=$path."UserDataModel.php";
            $this->registeredModel=$path."RegisteredModel.php";
            $this->signModel=$path."SignModel.php";
            $this->loadDataModel=$path."LoadDataModel.php";
        }
    }

    class ViewPath{
        public $registeredView;
        public $indexView;
        public $signView;
        public $personView;

        public function __construct()
        {
            $path=dirname(__FILE__)."/View/";
            $this->registeredView=$path."RegisteredView.php";
            $this->indexView=$path."IndexView.php";
            $this->signView=$path."SignView.php";
            $this->personView=$path."PersonView.php";
        }
    }

    class ControllerPath{
        public $registeredController;
        public $indexController;
        public $signController;
        public $personController;

        public function __construct()
        {
            
            $path=dirname(__FILE__)."/Controller/";
            $this->registeredController=$path."RegisteredController.php";
            $this->indexController=$path."IndexController.php";
            $this->signController=$path."SignController.php";
            $this->personController=$path."PersonController.php";
        }
    }

    class UserDataPath{
        public $userData;
        public $urlPath;
        public $hostPath;
        public $gallery;
        public $commission;
        public $product;

        public function __construct()
        {
            $host  = $_SERVER['HTTP_HOST'];
            //$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $this->urlPath="http://{$host}/material/";
            $this->hostPath=dirname(__FILE__)."/";
            //echo($this->userData."<br>");
            $this->userData="UserData/";
            $this->gallery="gallery";
            $this->commission="commission";
            $this->product="product";
        }
    }

    $objectPath=new ObjectPath();
    $listPath=new ListPath();

    $webPath=new WebPath();

    $locationPath=new WebPath();
    $locationPath->location();

    $modelPath=new ModelPath();
    $viewPath=new ViewPath();
    $controllerPath=new ControllerPath();

    $userDataPath=new UserDataPath();

    /*
    //Object路徑測試 
    require_once($objectPath->chatRecord);
    require_once($objectPath->chatroom);
    require_once($objectPath->comment);
    require_once($objectPath->commission);
    require_once($objectPath->cTag);
    require_once($objectPath->gallery);
    require_once($objectPath->gTag);
    require_once($objectPath->member);
    require_once($objectPath->product);
    require_once($objectPath->pTag);
    require_once($objectPath->sql);
    require_once($objectPath->tag);
    require_once($objectPath->track);
    require_once($objectPath->transaction);
 require_once($objectPath->gLike);
    echo("路徑測試 ".__FILE__."<br>");
     

    //List路徑測試
    require_once($listPath->memberList);
    require_once($listPath->galleryList);
    require_once($listPath->commissionList);
    require_once($listPath->product);
    require_once($listPath->commentList);

    require_once($listPath->chatroomList);
    require_once($listPath->chatRecordList);
    require_once($listPath->tagList);
   require_once($listPath->likeList);

    */

    

    /*
    //web路徑測試
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'web/index.html';
    //echo("Location: http://{$host}{$uri}/{$extra}");
    header("Location: http://{$host}{$uri}/{$extra}");
    //header("Location: ".$webPath->registered);
    
    header($locationPath->index);
*/



/*
    //Model路徑測試
    require_once($modelPath->userDataModel);
    require_once($modelPath->registeredModel);
    require_once($modelPath->signModel);
    require_once($modelPath->showDataModel);
    require_once($modelPath->loadDataModel);
*/



/*
    //View路徑測試
    require_once($viewPath->registeredView);
    require_once($viewPath->indexView);
    require_once($viewPath->signView);
require_once($viewPath->personView);

    */
    



/*
    //Controller路徑測試
    require_once($controllerPaht->registeredController);
    require_once($controllerPaht->indexController);
    require_once($controllerPaht->signController);
require_once($controllerPaht->personController);
    */

    
    

?>