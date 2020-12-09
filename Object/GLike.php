<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    class GLike{
        public $mID;
        public $gID;

        public function __construct()
        {
            $this->mID=null;
            $this->gID=null;
        }

        public function isExist(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "SELECT * 
            FROM gLike 
            WHERE ? = mID AND ? = gID";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si",$this->mID, $this->gID);
            $stmt->execute();

            $result=$stmt->get_result();
            
            $isSuccess=true;
            //沒結果
            if($result->num_rows==0){
                $isSuccess = false;
            }

            $result->free();
            $mysqli->close();
            return $isSuccess;
        }

        public function insert(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO gLike(mID,gID) 
            VALUES(?,?);";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $this->mID, $this->gID);
            $stmt->execute();

            $mysqli->close();

        }

        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM gLike
            WHERE mID=? AND gID=?;";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $this->mID, $this->gID);
            $stmt->execute();

            $mysqli->close();

        }

    }

    //echo("路徑測試 ".__FILE__."<br>");

    //測試
    /*
    $gLike=new GLike();
    $gLike->gID=12;
    $gLike->mID="brian60814@gmail.com";
    $gLike->delete();
    */
?>