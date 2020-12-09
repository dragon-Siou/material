<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    //沒有修改
    class PTag{
        public $tName;
        public $pID;

        public function __construct()
        {
            $this->tName=null;
            $this->pID=null;
        }

        public function load($tName,$pID){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * 
            FROM ptag
            WHERE ? = tName AND ?=pID";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $tName, $pID);
            $stmt->execute();

            $result=$stmt->get_result();
            
            $isSuccess=true;

            if($result->num_rows==0){
                //echo("{$tName} {$pID}查無結果");
                $isSuccess=false;
            }
            else{
                $row=$result->fetch_assoc();

                $this->tName=$row['tName'];
                $this->pID=$row['pID'];

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
            if($this->pID == null){
                throw new Exception("作品ID為空");
            }
            
        }

        //新增
        public function insert(){

            //檢查
            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO ptag(tName,pID) 
            VALUES(?,?);";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $this->tName, $this->pID);
            $stmt->execute();

            $mysqli->close();

        }

        //刪除
        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM ptag  
            WHERE ? = tName AND ?=pID;";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $this->tName, $this->pID);
            $stmt->execute();

            $mysqli->close();
        }

    }

    /*
    //讀取測試
    $test=new PTag();
    if($test->load("修改tag",1)){
        echo("{$test->pID} {$test->tName}");
    }
    

    //新增測試
    $test2=new PTag();
    $test2->tName="tag2";
    $test2->pID=1;
    $test2->insert();


    //刪除測試
    $test3=new PTag();
    $test3->tName="tag2";
    $test3->pID=1;
    $test3->delete();
*/

    
    //echo("路徑測試 ".__FILE__."<br>");
    
?>