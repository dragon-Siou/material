<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->commission);


    class CommissionList{
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
                //echo(" 沒有委託");
                $isSuccess = false;
            }
            else{

                $i=0;
                while($row=$result->fetch_assoc()){
                    
                    $this->data[$i]=new Commission();

                    $this->data[$i]->cID=$row['cID'];
                    $this->data[$i]->ID=$row['cID'];
                    $this->data[$i]->link=$row['link'];
                    $this->data[$i]->title=$row['title'];
                    $this->data[$i]->content=$row['content'];
                    $this->data[$i]->time=substr($row['time'],0 ,16 );
                    $this->data[$i]->mID=$row['mID'];
                    $i++;
                }
                

                //echo("{$row['mID']} {$row['userName']} {$row['password']}");
            }

            $result->free();
            $mysqli->close();
            return $isSuccess;
        }

        public function loadAll(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT *
            FROM commission";

            $stmt = $mysqli->prepare($sql);
            $stmt->execute();

            return $this->load($mysqli, $stmt);
        }

        public function loadFromMember($mID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT *
            FROM commission
            WHERE mID=?
            ORDER BY time DESC";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s",$mID);
            $stmt->execute();

            return $this->load($mysqli, $stmt);
            
        }

        public function loadFromKey($key){

            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT * 
            FROM commission AS A
            WHERE A.title LIKE '%{$key}%' OR
            EXISTS(
                SELECT B.tName
                FROM ctag AS B
                WHERE A.cID=B.cID AND B.tName LIKE '%{$key}%'
            )
            ORDER BY time DESC";

            $stmt = $mysqli->prepare($sql);
            //$stmt->bind_param("s",$key);
            $stmt->execute();

            return $this->load($mysqli, $stmt);
        }

    }
/*
    //讀取測試
    $commissionList=new CommissionList();
    
    if($commissionList->loadFromMID("brian60814@gmail.com")){
        foreach($commissionList->data as $commission){
            echo("{$commission->cID} {$commission->title} {$commission->content} <br>");
        }
    }


    if($commissionList->loadFromTag("testTag")){
        foreach($commissionList->commissionList as $commission){
            echo("{$commission->cID} {$commission->title} {$commission->content} <br>");
        }
    }



    if($commissionList->loadAll()){
        foreach($commissionList->data as $commission){
            echo("{$commission->cID} {$commission->title} {$commission->content} <br>");
        }
    }
*/    

    //echo("路徑測試 ".__FILE__."<br>");

?>