<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    class ChatRecord{
        public $crID;
        public $sendTime;
        public $sendMID;
        public $content;
        //public $errMsg;

        public function __construct()
        {
            $this->crID=null;
            $this->sendTime=null;
            $this->sendMID=null;
            $this->content=null;
            //$this->errMsg="ChatRecord:<br>";
        }

        public function load($crID,$sendTime,$sendMID){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * 
            FROM chatRecord
            WHERE ? = crID AND ?=sendTime AND ?=sendMID";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("iss", $crID, $sendTime, $sendMID);
            $stmt->execute();

            $result=$stmt->get_result();
            
            $isSuccess=true;

            if($result->num_rows==0){
                //$this->errMsg.="{$crID} {$sendTime} {$sendMID}查無結果<br>";
                $isSuccess=false;
            }
            else{
                $row=$result->fetch_assoc();

                $this->crID=$row['crID'];
                $this->sendTime=substr($row['sendTime'],0 ,16 );
                $this->sendMID=$row['sendMID'];
                $this->content=$row['content'];

                //echo("{$this->cID} {$this->link}");
            }

            $result->free();
            $mysqli->close();

            return $isSuccess;
        }

        //檢查資料
        private function checkData(){

            if($this->crID == null){
                throw new Exception("聊天室ID為空");
            }
            if($this->sendMID == null){
                throw new Exception("聊天的發送ID為空");
            }
            if($this->content == null){
                throw new Exception("聊天的內容為空");
            }
        
        }

        //新增
        public function insert(){

            //檢查
            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO chatRecord(crID, sendMID, content) 
            VALUES(?,?,?);";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("iss", $this->crID, $this->sendMID, $this->content);
            $stmt->execute();

            $mysqli->close();

        }

        //刪除
        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM chatRecord  
            WHERE ? = crID AND ?=sendTime AND ?=sendMID;";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("iss", $this->crID, $this->sendTime, $this->sendMID);
            $stmt->execute();

            $mysqli->close();
        }

    }

    /*
    //讀取測試
    $test=new ChatRecord();

    if($test->load(3,"2020-05-13 09:19:57.042","brian60814@gmail.com")){
        echo("{$test->crID} {$test->sendTime} {$test->sendMID}");
    }
   

    //插入測試
    $test2=new ChatRecord();
    $test2->crID=6;
    $test2->sendMID="brian60814@gmail.com";
    $test2->content="午安";
    $test2->insert();
 

    //刪除測試
    $test3=new ChatRecord();
    $test3->crID=3;
    $test3->sendMID="brian60814@gmail.com";
    $test3->sendTime="2020-05-13 09:35:17.894";
    $test3->delete();
*/

    //echo("路徑測試 ".__FILE__."<br>");

?>