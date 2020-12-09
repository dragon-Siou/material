<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($listPath->galleryList);
    require_once($listPath->productList);
    require_once($listPath->commissionList);
    
    class LoadDataModel{
        public $data;
        public $isGallery;
        public $dataType;

        private $dataList;
        

        //初始化
        public function __construct($dataType)
        {

            $this->dataType=$dataType;
            switch($dataType){

                case "gallery":
                    $this->dataList=new GalleryList();
                    break;
    
                case "product":
                    $this->dataList=new ProductList();
                    break;
    
                case "commission":
                    $this->dataList=new CommissionList();
                    break;
            }
        }

        public function loadFromKey($key){
            if($this->dataList->loadFromKey($key)){
                $this->data=$this->dataList->data;
                return true;
            }
            return false;
        }
        
        public function loadFromMember($memberID){
            if($this->dataList->loadFromMember($memberID)){
                $this->data=$this->dataList->data;
                return true;
            }
            return false;
        }

    }
    
    //echo("路徑測試 ".__FILE__."<br>");
?>