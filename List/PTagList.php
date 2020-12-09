<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->tag);
    require_once($objectPath->pTag);

    class PTagList{
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
                    
                    $this->data[$i]=new PTag();

                    $this->data[$i]->tName=$row['tName'];
                    $this->data[$i]->pID=$row['pID'];
                    $i++;
                }
                

                //echo("{$row['mID']} {$row['userName']} {$row['password']}");
            }

            $result->free();
            $mysqli->close();
            return $isSuccess;
        }

        public function loadFromProduct($pID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT * FROM ptag 
            WHERE pID = ?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $pID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }

        public function deleteAll(){
            foreach( $this->data as $pTag) {
                $pTag->delete();
            }
        }

        // public function deleteAll(){
        //     foreach ($this->data as $tag) {
        //         $tag->delete();
        //     }
        // }

    }
?>