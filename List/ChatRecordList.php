<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->chatRecord);

    class ChatRecordList{
        public $data;

        public function __construct()
        {
            $this->data=array();
        }

        private function load($mysqli,$stmt){

            $result=$stmt->get_result();

            $isSuccess=true;
            //沒結果
            if($result->num_rows==0){
                //echo("沒有商品");
                $isSuccess = false;
            }
            else{

                $i=0;
                while($row=$result->fetch_assoc()){
                    
                    $this->data[$i]=new ChatRecord();

                    $this->data[$i]->crID=$row['crID'];
                    $this->data[$i]->sendTime=substr($row['sendTime'],0 ,16 );
                    $this->data[$i]->sendMID=$row['sendMID'];
                    $this->data[$i]->content=$row['content'];
                    $i++;
                }
                

                //echo("{$row['mID']} {$row['userName']} {$row['password']}");
            }

            $result->free();
            $mysqli->close();
            return $isSuccess;
        }

        public function loadFromChatroom($crID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT * 
            FROM chatrecord
            WHERE crID=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $crID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }

        public function loadNewFromChatroom($crID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT * 
            FROM chatrecord 
            WHERE crID=?
            ORDER BY sendTime DESC
            LIMIT 1";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $crID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }
    }

/*
    $chatRecordList=new ChatRecordList();

    if($chatRecordList->loadFromChatroom(6)){
        foreach($chatRecordList->data as $chatRecord){
            echo("{$chatRecord->crID} {$chatRecord->sendTime} 
            {$chatRecord->sendMID} {$chatRecord->content} <br>");
        }
    }
*/
    //echo("路徑測試 ".__FILE__."<br>");
?>