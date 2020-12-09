<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->member);


    class MemberList{
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
                //echo("{$mID} 沒有追蹤的人");
                $isSuccess = false;
            }
            else{

                $i=0;
                while($row=$result->fetch_assoc()){
                    $this->data[$i]=new Member();

                    $this->data[$i]->mID=$row['mID'];
                    $this->data[$i]->key=$row['mID'];
                    $this->data[$i]->userName=$row['userName'];
                    $this->data[$i]->password=$row['password'];
                    $this->data[$i]->enable=$row['enable'];
                    $i++;
                }
                

                //echo("{$row['mID']} {$row['userName']} {$row['password']}");
            }

            $result->free();
            $mysqli->close();
            return $isSuccess;
        }

        //全部
        public function loadAll(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "SELECT *
            FROM member";

            $stmt = $mysqli->prepare($sql);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }

        //追蹤誰
        public function loadFromTrackMID($mID){

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "SELECT B.mID,B.userName,B.password,B.enable
            FROM track AS A,member AS B
            WHERE A.trackID=B.mID AND A.mID=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s",$mID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
            
        }

        //找被追蹤的
        public function loadFromTrackTrackID($trackID){

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "SELECT B.mID,B.userName,B.password,B.enable
            FROM track AS A,member AS B
            WHERE A.mID=B.mID AND A.trackID=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s",$trackID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }
        
    }

  /*  
    //讀取測試 "johnny4478@gmail.com"
    $trackList=new MemberList();
    if($trackList->loadFromTrackMID("test")){
        foreach($trackList->data as $member){
            echo("{$member->mID} {$member->userName} {$member->password} {$member->enable} <br>");
        }
    }
    */
    
    //echo("路徑測試 ".__FILE__."<br>");
?>