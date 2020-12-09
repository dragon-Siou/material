<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    class Track{
        public $mID;
        public $trackID;

        public function __construct()
        {
            $this->mID=null;
            $this->trackID=null;
        }

        public function load($mID,$trackID){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * 
            FROM track
            WHERE ? = mID AND ?=trackID";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $mID, $trackID);
            $stmt->execute();

            $result=$stmt->get_result();
            
            $isSuccess=true;

            if($result->num_rows==0){
                //echo("{$mID} {$trackID}查無結果");
                $isSuccess=false;
            }
            else{
                $row=$result->fetch_assoc();

                $this->mID=$row['mID'];
                $this->trackID=$row['trackID'];

                //echo("{$this->cID} {$this->link}");
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
            if($this->trackID == null){
                throw new Exception("追蹤ID為空");
            }
            
        }

        //新增
        public function insert(){

            //檢查
            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO track(mID,trackID) 
            VALUES(?,?);";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $this->mID, $this->trackID);
            $stmt->execute();

            $mysqli->close();

        }

        //刪除
        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM track  
            WHERE ? = mID AND ?=trackID;";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $this->mID, $this->trackID);
            $stmt->execute();

            $mysqli->close();
        }

    }

    /*
    //讀取測試
    $test=new Track();
    if($test->load("johnny4478@gmail.com", "brian60814@gmail.com")){
        echo("{$test->mID} {$test->trackID}");
    }

    //新增測試
    $test2=new Track();
    $test2->mID="brian60814@gmail.com";
    $test2->trackID="johnny4478@gmail.com";
    $test2->insert();
    

    //刪除測試
    $test3=new Track();
    $test3->mID="brian60814@gmail.com";
    $test3->trackID="johnny4478@gmail.com";
    $test3->delete();
*/

    //echo("路徑測試 ".__FILE__."<br>");

?>