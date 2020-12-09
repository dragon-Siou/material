<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    //沒有修改
    class CTag{
        public $tName;
        public $cID;

        public function __construct()
        {
            $this->tName=null;
            $this->cID=null;
        }

        public function load($tName,$cID){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * 
            FROM ctag
            WHERE ? = tName AND ?=cID";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $tName, $cID);
            $stmt->execute();

            $result=$stmt->get_result();
            
            $isSuccess=true;

            if($result->num_rows==0){
                //echo("{$tName} {$cID}查無結果");
                $isSuccess=false;
            }
            else{
                $row=$result->fetch_assoc();

                $this->tName=$row['tName'];
                $this->cID=$row['cID'];

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
            if($this->cID == null){
                throw new Exception("委託ID為空");
            }
            
        }

        //新增
        public function insert(){

            //檢查
            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO ctag(tName,cID) 
            VALUES(?,?);";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $this->tName, $this->cID);
            $stmt->execute();

            $mysqli->close();

        }

        //刪除
        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM ctag  
            WHERE ? = tName AND ?=cID;";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $this->tName, $this->cID);
            $stmt->execute();

            $mysqli->close();
        }

    }

    /*
    //讀取測試
    $test=new CTag();
    if($test->load("修改tag",2)){
        echo("{$test->cID} {$test->tName}");
    }
    

    //新增測試
    $test2=new CTag();
    $test2->tName="tag2";
    $test2->cID=2;
    $test2->insert();


    //刪除測試
    $test3=new CTag();
    $test3->tName="tag2";
    $test3->cID=2;
    $test3->delete();
*/
    //echo("路徑測試 ".__FILE__."<br>");
?>