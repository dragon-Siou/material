<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    class Member{

        public $mID;
        public $key;
        public $userName;
        public $password;
        public $enable;
        public $profile;
        public $pLink;
        
        public function __construct(){
            $this->mID=null;
            $this->key=null;
            $this->userName=null;
            $this->password=null;
            $this->enable="Y";
            $this->pLink=null;
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

        public function comparePassword($password){
            if($this->password === $password){
                return true;
            }
            return false;
        }
        
        public function isExist(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "SELECT * 
            FROM member 
            WHERE ? = mID";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s",$this->mID);
            $stmt->execute();

            $result=$stmt->get_result();
            
            $isSuccess=true;
            //沒結果
            if($result->num_rows==0){
                $isSuccess = false;
            }

            $result->free();
            $mysqli->close();
            return $isSuccess;
        }

        public function load($mID){

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "SELECT * 
            FROM member 
            WHERE ? = mID";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s",$mID);
            $stmt->execute();

            $result=$stmt->get_result();
            
            $isSuccess=true;
            //沒結果
            if($result->num_rows==0){
                //echo("{$mID}查無結果");
                $isSuccess = false;
            }
            else{
                $row=$result->fetch_assoc();

                $this->mID=$row['mID'];
                $this->key=$row['mID'];
                $this->userName=$row['userName'];
                $this->password=$row['password'];
                $this->enable=$row['enable'];
                $this->profile=$row['profile'];
                $this->pLink=$row['pLink'];
                
                //預設資料
                if(empty($this->pLink)){
                    $this->pLink="web/images/default_pic.png";
                }

                //echo("{$row['mID']} {$row['userName']} {$row['password']}");
            }

            $result->free();
            $mysqli->close();
            return $isSuccess;
        }

        //檢查資料
        private function checkData(){
            if($this->mID == null){
                throw new Exception("會員ID為空");
            }
            if($this->userName == null){
                throw new Exception("會員名字為空");
            }
            if($this->password == null){
                throw new Exception("會員密碼為空");
            }
            if($this->enable == null){
                throw new Exception("會員啟用欄位為空");
            }
            
        }

        //要完整才可以update
        public function update(){
            //檢查
            $this->checkData();
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "UPDATE member 
            SET mID=?, userName=?, password=?,profile=? ,enable=? ,pLink=?
            WHERE ? = mID";

            $stmt=$mysqli->prepare($sql);
            $stmt->bind_param("sssssss", $this->mID, $this->userName, 
                $this->password,$this->profile ,$this->enable, $this->pLink , $this->key);
            $stmt->execute();

            $mysqli->close();
        }

        //新增
        public function insert(){

            //檢查
            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO member(mID,userName,password,enable) 
            VALUES(?,?,?,?);";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ssss", $this->mID, $this->userName, $this->password, $this->enable);
            $stmt->execute();

            $mysqli->close();

        }

        //刪除
        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM member  
            WHERE ? = mID;";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $this->mID);
            $stmt->execute();

            $mysqli->close();
        }

    }
/*
    //更新測試
    $test=new Member();

    if($test->load("brian60814@gmail.com")){
        $test->mID="brian60814@gmail.com";
        $test->userName="siou";
        $test->setEnable(true);
    
       $test->update();
    }
    
    

    //新增測試 錯誤測試
    $test2=new Member();
    $test2->mID="aaa@gamil.com";
    $test2->userName="test";
    $test2->password="2222";
    $test2->setEnable(true);

    $test2->insert();
    

    //刪除測試
    $test3=new Member();
    $test3->load("aaa@gamil.com");
    $test3->delete();
*/

    //echo("路徑測試 ".__FILE__."<br>");

?>