<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    class Tag{
        public $tName;
        public $key;

        public function __construct()
        {
            $this->tName=null;
            $this->key=null;
        }

        public function load($tName){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * 
            FROM tag
            WHERE ? = tName";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s",$tName);
            $stmt->execute();

            $result=$stmt->get_result();
            
            $isSuccess=true;

            if($result->num_rows==0){
                //echo("{$tName}查無結果");
                $isSuccess=false;
            }
            else{
                $row=$result->fetch_assoc();

                $this->tName=$row['tName'];
                $this->key=$row['tName'];

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
            
        }

        //更新資料
        public function update(){

            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "UPDATE tag 
            SET tName=? 
            WHERE ? = tName";

            $stmt=$mysqli->prepare($sql);
            $stmt->bind_param("ss", $this->tName, $this->key);
            $stmt->execute();

            $mysqli->close();
        }

        //新增
        public function insert(){

            //檢查
            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO tag(tName) 
            VALUES(?);";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $this->tName);
            $stmt->execute();

            $mysqli->close();

        }


        //刪除
        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM tag  
            WHERE ? = tName;";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $this->tName);
            $stmt->execute();

            $mysqli->close();
        }

    }
/*
    //更新測試
    $test=new Tag();
    if($test->load("測試tag")){
        $test->tName="修改tag";
        $test->update();
    }
    

    //新增測試 錯誤測試
    $test2=new Tag();
    $test2->tName="新增tag";
    $test2->insert();


    //刪除測試
    $test3=new Tag();
    if($test3->load("新增tag")){
        $test3->delete();
    }
*/

    //echo("路徑測試 ".__FILE__."<br>");

?>