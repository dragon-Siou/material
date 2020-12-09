<?php
    require_once(dirname(__FILE__)."/../Path.php");

    class UserDataModel{

        private $path;
        private $rootPath;
        private $userDataPath;

        public function __construct($mID)
        {
            $this->userDataPath=new UserDataPath();
            
            $this->rootPath=$this->userDataPath->userData. $mID;
            $this->path=$this->rootPath;
            
            //echo($this->path."<br>");
            $hostPath=$this->userDataPath->hostPath. $this->path;
            //路徑不存在
            if(!is_dir($hostPath)){
                mkdir($hostPath);
                mkdir($hostPath."/". $this->userDataPath->gallery);
                mkdir($hostPath."/". $this->userDataPath->commission);
                mkdir($hostPath."/". $this->userDataPath->product);
                
            }
        
        }

        public function getPath(){
            return $this->path;
        }

        public function getRootPath(){
            return $this->rootPath;
        }

        public function getRelativePath(){
            return "../" . $this->path;
        }

        public function getUrlPath(){
            return $this->userDataPath->urlPath. $this->path;
        }

        public function getHostPath(){
            return $this->userDataPath->hostPath. $this->path;
        }

        public function changePathToGallery(){
            $this->path=$this->rootPath . "/" . $this->userDataPath->gallery;
        }

        public function changePathToCommission(){
            $this->path=$this->rootPath . "/" . $this->userDataPath->commission;
        }

        public function changePathToProduct(){
            $this->path=$this->rootPath . "/" . $this->userDataPath->product;
        }

        public function deleteFile($fileName){
            if(unlink($this->path."/".$fileName)){
                return true;
            }
            return false;
        }
    }

    /*
    //新增會員資料夾測試
    $userDataModel=new UserDataModel("brian60814@gmail.com");
    $userDataModel->changePathToGallery();
    $userDataModel->deleteFile("1.jpg");
*/

    //echo("路徑測試 ".__FILE__."<br>");
?>