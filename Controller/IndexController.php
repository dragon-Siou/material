<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($modelPath->userDataModel);
    require_once($objectPath->gallery);
    require_once($listPath->galleryList);

    class IndexController{
        private $galleryList;
        public $errMsg;
        public $pathMsg;

        private const search = "search";
        private const searchType = "searchType";

        public function __construct()
        {
            $this->errMsg="IndexController errMsg:<br>";
            $this->pathMsg="IndexController pathMsg:<br>";
            //測試
            session_start();
            if(isset($_SESSION["memberID"])){
                echo($_SESSION["memberID"]);
            }

            //接收search
            

            $this->galleryList=new GalleryList();
            $this->galleryList->loadAll();
        }

        public function getGalleryData(){
            return $this->galleryList->data;
        }



        
    }

    /*
    //插入測試
    $userDataModel=new UserDataModel("brian60814@gmail.com");
    $userDataModel->changePathToGallery();
    echo($userDataModel->getHostPath()."<br>");
    $files= scandir($userDataModel->getHostPath());
    
    
    foreach($files as $file){
        if($file!="." && $file!=".."){
            $gallery=new Gallery();
            $gallery->mID="brian60814@gmail.com";
            $gallery->title="測試圖片";
            $gallery->link=$userDataModel->getPath()."/".$file;
            $gallery->insert();
        }
    }
*/

    //echo("路徑測試 ".__FILE__."<br>");
?>