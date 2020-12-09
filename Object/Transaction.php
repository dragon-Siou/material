<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    class Transaction{
        public $pID;
        public $mID;
        public $tTime;
        public $price;

        public function __construct()
        {
            $this->pID=null;
            $this->mID=null;
            $this->tTime=null;
            $this->price=null;
        }


        //用ID載入資料
        public function load($pID,$mID){
            $mysqli=(new DBConnetor())->getMysqli();
        
            $sql = "SELECT * 
            FROM transaction 
            WHERE ? = pID AND ?=mID";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("is", $pID, $mID);
            $stmt->execute();

            $result=$stmt->get_result();
        
            $isSuccess=true;
            //沒結果
            if($result->num_rows==0){
                //echo("{$pID} {$mID}查無結果");
                $isSuccess=false;
            }
            else{
                $row=$result->fetch_assoc();

                $this->pID=$row['pID'];
                $this->mID=$row['mID'];
                $this->tTime=substr($row['tTime'],0 ,16 );
                $this->price=$row['price'];

                
            }

            $result->free();
            $mysqli->close();

            return $isSuccess;
        }

        //檢查資料
        private function checkData(){

            if($this->pID == null){
                throw new Exception("交易的商品ID為空");
            }
            if($this->mID == null){
                throw new Exception("交易的買家ID為空");
            }
            
        }

        //更新資料
        public function update(){

            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();
            
            
            $sql = "UPDATE Transaction  
            SET pID=?, mID=?, tTime=?, price=? 
            WHERE ? = pID AND ?=mID";

            $stmt=$mysqli->prepare($sql);
            $stmt->bind_param("issiis", $this->pID, $this->mID, $this->tTime, 
                $this->price, $this->pID, $this->mID);
            $stmt->execute();

            $mysqli->close();
        }

        //新增
        public function insert(){

            //檢查
            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO Transaction(pID,mID,price) 
            VALUES(?,?,?);";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("isi", $this->pID, $this->mID, $this->price);
            $stmt->execute();

            $mysqli->close();

        }

        //刪除
        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM transaction  
            WHERE ? = pID AND ?=mID;";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("is",$this->pID , $this->mID);
            $stmt->execute();

            $mysqli->close();
        }

    }

    /*
    //更新測試
    $test=new Transaction();
    if($test->load(1,"brian60814@gmail.com")){
        $test->price=20;
        $test->update();
    }
   

    //新增測試 錯誤測試
    $test2=new Transaction();
    $test2->pID=3;
    //$test2->mID="brian60814@gmail.com";
    $test2->price=500;
    $test2->insert();


    //刪除測試
    $test3=new Transaction();
    $test3->load(3,"brian60814@gmail.com");
    $test3->delete();
 */

    //echo("路徑測試 ".__FILE__."<br>");
?>

