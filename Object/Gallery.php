<?php

    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    class Gallery{
        public $ID;
        public $gID;
        //public $gLike;
        public $link;
        public $mID;
        public $title;
        public $info;
        public $content;
        public $time;
        public $type;

        public function __construct(){
            $this->gID=null;
            //$this->gLike=0;
            $this->link=null;
            $this->mID=null;
            $this->title=null;
            $this->info="";
            $this->time=null;
            $this->type="gallery";
        }

        //用ID載入資料
        public function load($gID){
            $mysqli=(new DBConnetor())->getMysqli();
        
            $sql = "SELECT * 
            FROM gallery 
            WHERE ? = gID";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i",$gID);
            $stmt->execute();

            $result=$stmt->get_result();
        
            $isSuccess=true;
            //沒結果
            if($result->num_rows==0){
                //echo("{$gID}查無結果");
                $isSuccess=false;
            }
            else{
                $row=$result->fetch_assoc();

                $this->gID=$row['gID'];
                $this->ID=$row['gID'];
                //$this->gLike = $row['gLike'];
                $this->link=$row['link'];
                $this->mID=$row['mID'];
                $this->title=$row['title'];
                $this->content=$row['info'];
                $this->info=$row['info'];
                $this->time=substr($row['time'],0 ,16 );

                //echo("{$row['title']} {$row['info']} {$row['time']}");
            }

            $result->free();
            $mysqli->close();

            return $isSuccess;
        }

        //檢查資料
        private function checkData(){

            if($this->link == null){
                throw new Exception("作品連結為空");
            }
            if($this->mID == null){
                throw new Exception("作品的作者ID為空");
            }
            if($this->title == null){
                throw new Exception("作品標題為空");
            }
            
        }

        //更新資料
        public function update(){

            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "UPDATE gallery  
            SET link=?, title=?, info=? 
            WHERE gID = ? ;";

            $stmt=$mysqli->prepare($sql);
            $stmt->bind_param("sssi" ,$this->link , $this->title, $this->info, $this->gID);
            $stmt->execute();

            $mysqli->close();
        }

        //新增資料
        public function insert(){

            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO gallery(link,title,info,mID) 
            VALUES(?,?,?,?);";

            $stmt=$mysqli->prepare($sql);
            $stmt->bind_param("ssss", $this->link, $this->title, $this->info, $this->mID);
            $stmt->execute();

            $mysqli->close();
        }

        //刪除
        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM gallery  
            WHERE ? = gID;";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $this->gID);
            $stmt->execute();

            $mysqli->close();
        }

    }

 /*
    //更新測試
    $test2=new Gallery();
    //編號是流水號，要對一下
    if($test2->load(5)){
        $test2->info="修改成功";
        $test2->link="xxxxx";
        $test2->update();
    }
   


    
    //新增測試 錯誤測試
    $test=new Gallery();
    $test->gLike=0;
    $test->link="zzz";
    $test->title="作品";
    $test->info="這是測試";
    $test->mID="brian60814@gmail.com";
    $test->insert();


    //刪除測試
    $test3=new Gallery();
    //編號是流水號，要對一下
    $test3->load(4);
    $test3->delete();
*/
    //echo("{$test->getTitle()}");
    
    //echo("路徑測試 ".__FILE__."<br>");
?>