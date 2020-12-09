<?php

    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    class Product{
        public $ID;
        public $pID;
        public $link;
        public $title;
        public $content;
        public $price;
        public $time;
        public $enable;
        public $mID;
        public $type;

        public function __construct(){
            $this->pID=null;
            $this->link=null;
            $this->title=null;
            $this->content="";
            $this->price=null;
            $this->time=null;
            $this->enable="Y";
            $this->mID=null;
            $this->type="product";
        }

        public function isEnable(){
            if($this->enable === 'Y'){
                return true;
            }
            return false;
        }

        public function setEnable($enable){
            //啟用
            if($enable){
                $this->enable="Y";
            }
            else{
                $this->enable="N";
            }
        }

        public function load($pID){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * 
            FROM product
            WHERE ? = pID";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i",$pID);
            $stmt->execute();

            $result=$stmt->get_result();
            
            $isSuccess=true;

            if($result->num_rows==0){
                //echo("{$pID}查無結果");
                $isSuccess=false;
            }
            else{
                $row=$result->fetch_assoc();

                $this->ID=$row['pID'];
                $this->pID=$row['pID'];
                $this->link=$row['link'];
                $this->title=$row['title'];
                $this->content=$row['content'];
                $this->price=$row['price'];
                $this->time=substr($row['time'],0 ,16 );
                $this->enable=$row['enable'];
                $this->mID=$row['mID'];

                //echo("{$this->cID} {$this->link}");
            }

            $result->free();
            $mysqli->close();

            return $isSuccess;
        }

        //檢查資料
        private function checkData(){

            if($this->link == null){
                throw new Exception("商品連結為空");
            }
            if($this->mID == null){
                throw new Exception("商品的標題ID為空");
            }
            if($this->title == null){
                throw new Exception("商品的標題為空");
            }
            if($this->enable == null){
                throw new Exception("商品的啟用欄位為空");
            }
            if($this->price === null){
                throw new Exception("商品的價格為空");
            }
            
        }

        //要完整才可以update
        public function update(){
            //檢查
            $this->checkData();
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "UPDATE product 
            SET link=?, title=?, content=?, price=?, enable=? 
            WHERE ? = pID";

            $stmt=$mysqli->prepare($sql);
            $stmt->bind_param("sssisi", 
                $this->link, $this->title, $this->content, 
                $this->price, $this->enable, $this->pID);

            $stmt->execute();

            $mysqli->close();
        }

        //新增
        public function insert(){

            //檢查
            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO product(link,title,content,price,enable,mID) 
            VALUES(?,?,?,?,?,?);";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sssiss", 
                $this->link, $this->title, $this->content, 
                $this->price, $this->enable, $this->mID);
            $stmt->execute();

            $mysqli->close();

        }

        //刪除
        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM product  
            WHERE ? = pID;";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $this->pID);
            $stmt->execute();

            $mysqli->close();
        }
        

    }
/*
    //更新測試
    $test=new Product();
    if($test->load(1)){
        $test->link="zzz.xxx";
        $test->title="作品";
        $test->content="這是測試";
        $test->mID="brian60814@gmail.com";
        $test->update();
    }
    

    //新增測試 錯誤測試
    $test2=new Product();
    $test2->link="zzz.xxx";
    $test2->title="作品";
    $test2->content="這是測試";
    $test2->mID="brian60814@gmail.com";
    $test2->price=0;
    $test2->insert();

    $test2=new Product();
    $test2->link="2.xxx";
    $test2->title="作品2";
    $test2->content="這是測試2";
    $test2->mID="brian60814@gmail.com";
    $test2->price=0;
    $test2->insert();

    //刪除測試
    $test3=new Product();
    if($test3->load(2)){
        $test3->delete();
    }
    */

    //echo("路徑測試 ".__FILE__."<br>");

?>