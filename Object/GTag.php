<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    //沒有修改
    class GTag{
        public $tName;
        public $gID;

        public function __construct()
        {
            $this->tName=null;
            $this->gID=null;
        }

        public function load($tName,$gID){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * 
            FROM gtag
            WHERE ? = tName AND ?=gID";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $tName, $gID);
            $stmt->execute();

            $result=$stmt->get_result();
            
            $isSuccess=true;

            if($result->num_rows==0){
                //echo("{$tName} {$gID}查無結果");
                $isSuccess=false;
            }
            else{
                $row=$result->fetch_assoc();

                $this->tName=$row['tName'];
                $this->gID=$row['gID'];

                //echo("{$this->cID} {$this->link}");
            }

            $result->free();
            $mysqli->close();

            return $isSuccess;
        }

        //檢查資料
        private function checkData(){

            if($this->tName == null){
                throw new Exception("tag的名字為空");
            }
            if($this->gID == null){
                throw new Exception("作品ID為空");
            }
            
        }

        //新增
        public function insert(){

            //檢查
            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO gtag(tName,gID) 
            VALUES(?,?);";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $this->tName, $this->gID);
            $stmt->execute();

            $mysqli->close();

        }

        //刪除
        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM gtag  
            WHERE ? = tName AND ?=gID;";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $this->tName, $this->gID);
            $stmt->execute();

            $mysqli->close();
        }

    }

    /*
    //讀取測試
    $test=new GTag();
    if($test->load("修改tag",2)){
        echo("{$test->gID} {$test->tName}");
    }
    

    //新增測試
    $test2=new GTag();
    $test2->tName="tag2";
    $test2->gID=2;
    $test2->insert();


    //刪除測試
    $test3=new GTag();
    $test3->tName="tag2";
    $test3->gID=2;
    $test3->delete();


*/
    
    //echo("路徑測試 ".__FILE__."<br>");
?>