<?php

    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->chatroom);

    class ChatroomList{
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
                //echo("沒有聊天室");
                $isSuccess = false;
            }
            else{

                $i=0;
                while($row=$result->fetch_assoc()){
                    
                    $this->data[$i]=new Chatroom();

                    $this->data[$i]->crID=$row['crID'];
                    $this->data[$i]->mID1=$row['mID1'];
                    $this->data[$i]->mID2=$row['mID2'];
                    $i++;
                }
                

                //echo("{$row['mID']} {$row['userName']} {$row['password']}");
            }

            $result->free();
            $mysqli->close();
            return $isSuccess;
        }

        public function loadFromMember($mID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "SELECT A.crID, A.mID1, A.mID2
            FROM chatroom AS A
            WHERE mID1=?
            UNION
            SELECT A.crID, A.mID2 AS mID1, A.mID1 AS mID2
            FROM chatroom AS A
            WHERE mID2=?";

            $stmt = $mysqli->prepare($sql);
            //echo($sql);
            $stmt->bind_param("ss",$mID,$mID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }
    }

    /*
    $chatroomList=new ChatroomList();

    if($chatroomList->loadFromMember("brian60814@gmail.com")){
        foreach($chatroomList->data as $chatroom){
            echo("{$chatroom->crID} {$chatroom->mID1} {$chatroom->mID2} <br>");
        }
    }
*/
    //echo("路徑測試 ".__FILE__."<br>");
?>