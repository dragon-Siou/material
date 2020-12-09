<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->tag);

    class TagList{
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
                //echo("沒有標籤");
                $isSuccess = false;
            }
            else{

                $i=0;
                while($row=$result->fetch_assoc()){
                    
                    $this->data[$i]=new Tag();

                    $this->data[$i]->tName=$row['tName'];
                    $this->data[$i]->key=$row['tName'];
                    $i++;
                }
                

                //echo("{$row['mID']} {$row['userName']} {$row['password']}");
            }

            $result->free();
            $mysqli->close();
            return $isSuccess;
        }

        public function loadFromCommission($cID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT A.tName
            FROM ctag AS A
            WHERE cID=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $cID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }

        public function loadFromProduct($pID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT A.tName
            FROM ptag AS A
            WHERE pID=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $pID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }

        public function loadFromGallery($gID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT A.tName
            FROM gtag AS A
            WHERE gID=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $gID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }

        // public function deleteAll(){
        //     foreach ($this->data as $tag) {
        //         $tag->delete();
        //     }
        // }

    }

/*
    $tagList=new TagList();

    if($tagList->loadFromCommission(2)){
        foreach($tagList->data as $tag){
            echo("{$tag->tName} <br>");
        }
    }


    if($tagList->loadFromProduct(1)){
        foreach($tagList->data as $tag){
            echo("{$tag->tName} <br>");
        }
    }

    if($tagList->loadFromGallery(2)){
        foreach($tagList->data as $tag){
            echo("{$tag->tName} <br>");
        }
    }*/

    //echo("路徑測試 ".__FILE__."<br>");

?>