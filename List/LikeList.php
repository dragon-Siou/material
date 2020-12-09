<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->gLike);

    class LikeList{
        public $data;
        public $count;

        public function __construct()
        {
            $this->data=array();
            $this->count=0;
        }

        public function loadFromGID($gID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT *
            FROM gLike
            WHERE gID=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i",$gID);
            $stmt->execute();

            $result=$stmt->get_result();

            $isSuccess=true;
            //沒結果
            if($result->num_rows==0){
                //echo("沒有作品");
                $isSuccess = false;
            }
            else{

                $i=0;
                while($row=$result->fetch_assoc()){
                    
                    $this->data[$i]=new GLike();

                    $this->data[$i]->mID=$row['mID'];
                    $this->data[$i]->gID=$row['gID'];

                    $this->count++;
                    $i++;
                }
                

                //echo("{$row['mID']} {$row['userName']} {$row['password']}");
            }

            $result->free();
            $mysqli->close();
            return $isSuccess;
        }



    }

    //echo("路徑測試 ".__FILE__."<br>");
/*
    $likeList = new LikeList();
    $likeList->loadFromGID(11);
    echo($likeList->count);*/
?>