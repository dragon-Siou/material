<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    class Chatroom{
        public $crID;
        public $mID1;
        public $mID2;
        //public $errMsg;

        public function __construct()
        {
            $this->crID=null;
            $this->mID1=null;
            $this->mID2=null;
            //$this->errMsg="Chatroom:<br>";
        }

        public function load($crID){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * 
            FROM chatroom
            WHERE ? = crID";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $crID);
            $stmt->execute();

            $result=$stmt->get_result();
            
            $isSuccess=true;

            if($result->num_rows==0){
                //$this->errMsg.="{$crID} 查無結果";
                $isSuccess=false;
            }
            else{
                $row=$result->fetch_assoc();

                $this->crID=$row['crID'];
                $this->mID1=$row['mID1'];
                $this->mID2=$row['mID2'];

                //echo("{$this->cID} {$this->link}");
            }

            $result->free();
            $mysqli->close();

            return $isSuccess;
        }

        public function loadFromMID($mID1,$mID2){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * 
            FROM chatroom
            WHERE ? = mID1 AND ?=mID2";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $mID1, $mID2);
            $stmt->execute();

            $result=$stmt->get_result();

            //查無結果，反過來查一次
            if($result->num_rows==0){
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ss", $mID2, $mID1);
                $stmt->execute();

                $result=$stmt->get_result();
            }

            $isSuccess=true;

            //真的沒查到
            if($result->num_rows==0){
                //$this->errMsg.="{$mID1} {$mID2}查無結果";
                $isSuccess=false;
            }
            else{
                $row=$result->fetch_assoc();

                $this->crID=$row['crID'];
                $this->mID1=$row['mID1'];
                $this->mID2=$row['mID2'];
            }

            $result->free();
            $mysqli->close();

            return $isSuccess;


        }

        //檢查資料
        private function checkData(){

            if($this->mID1 == null){
                throw new Exception("會員1的ID為空");
            }

            if($this->mID2 == null){
                throw new Exception("會員2的ID為空");
            }
        }

        //新增
        public function insert(){

            //檢查
            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO chatroom(mID1, mID2) 
            VALUES(?,?);";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $this->mID1, $this->mID2);
            $stmt->execute();

            $mysqli->close();

        }

        //刪除
        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM chatroom  
            WHERE ? = crID;";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $this->crID);
            $stmt->execute();

            $mysqli->close();
        }


    }

    //讀取測試
    /*
    $test=new Chatroom();
    if($test->loadFromMID("brian60814@gmail.com","johnny4478@gmail.com")){
        echo("{$test->crID} {$test->mID1} {$test->mID2}");
    }

    //插入測試
    $test2=new Chatroom();
    $test2->mID1="test";
    $test2->mID2="brian60814@gmail.com";
    $test2->insert();


    $test3=new Chatroom();
    if($test3->loadFromMID("brian60814@gmail.com","johnny4478@gmail.com")){
        $test3->delete();
    }
*/

    //echo("路徑測試 ".__FILE__."<br>");

?>