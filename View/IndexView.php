<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($controllerPath->indexController);
    
    class IndexView{
        private $indexController;

        public function __construct()
        {
            $this->indexController=new IndexController();
        }

        public function printImages(){
            /*<div class="box">
            <img src="images/1.jpg">
            </div> */
            $datas=$this->indexController->getGalleryData();
            foreach($datas as $data){
                //echo($data->link);
                echo("<div class='box'>
                <img src='../{$data->link}'>
                </div>");
            }
        }
    }

    //echo("路徑測試 ".__FILE__."<br>");
?>