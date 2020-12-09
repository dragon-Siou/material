<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->transaction);

    class TransactionList{
        public $data;
        

        public function __construct()
        {
            $this->data=array();
        }

        public function loadFromMember($mID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT *
            FROM transaction
            WHERE mID=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s",$mID);
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
                    
                    $this->data[$i]=new Transaction();

                    $this->data[$i]->pID=$row['pID'];
                    $this->data[$i]->mID=$row['mID'];
                    $this->data[$i]->tTime=substr($row['tTime'],0 ,16 );
                    $this->data[$i]->price=$row['price'];

                    //$this->count++;
                    $i++;
                }
                

                //echo("{$row['mID']} {$row['userName']} {$row['password']}");
            }

            $result->free();
            $mysqli->close();
            return $isSuccess;
        }

    }
?>