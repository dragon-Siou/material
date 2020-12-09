<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    class Commission{
        public $ID;
        public $cID;
        public $link;
        public $title;
        public $content;
        public $time;
        public $mID;
        public $type;

        public function __construct(){
            $this->cID=null;
            $this->link=null;
            $this->title=null;
            $this->content=null;
            $this->time=null;
            $this->mID=null;
            $this->type="commission";
        }

        public function getCID(){
            return $this->cID;
        }

        public function getTime(){
            return $this->time;
        }

        public function load($cID){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * 
            FROM commission
            WHERE ? = cID";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i",$cID);
            $stmt->execute();

            $result=$stmt->get_result();
            
            $isSuccess=true;

            if($result->num_rows==0){
                //echo("{$cID}查無結果");
                $isSuccess=false;
            }
            else{
                $row=$result->fetch_assoc();

                $this->ID=$row['cID'];
                $this->cID=$row['cID'];
                $this->link=$row['link'];
                $this->title=$row['title'];
                $this->content=$row['content'];
                $this->time=substr($row['time'],0 ,16 );
                $this->mID=$row['mID'];

                //echo("{$this->cID} {$this->link}");
            }

            $result->free();
            $mysqli->close();

            return $isSuccess;
        }

        //檢查資料
        private function checkData(){

            if($this->link == null){
                throw new Exception("委託連結為空");
            }
            if($this->mID == null){
                throw new Exception("委託的作者ID為空");
            }
            if($this->title == null){
                throw new Exception("委託標題為空");
            }
            
        }

        //更新資料
        public function update(){

            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "UPDATE Commission  
            SET link=?, title=?, content=? 
            WHERE ? = cID";

            $stmt=$mysqli->prepare($sql);
            $stmt->bind_param("sssi", $this->link, $this->title, $this->content, $this->cID);
            $stmt->execute();

            $mysqli->close();
        }

        //新增
        public function insert(){
            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO Commission(link,title,content,mID) 
            VALUES(?,?,?,?);";

            $stmt=$mysqli->prepare($sql);
            $stmt->bind_param("ssss", $this->link, $this->title, $this->content, $this->mID);
            $stmt->execute();

            $mysqli->close();
        }

        //刪除
        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM commission  
            WHERE ? = cID;";
            
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $this->cID);
            $stmt->execute();

            $mysqli->close();
        }

    }

    /*
    //更新測試
    $test=new Commission();
    if($test->load(2)){
        $test->title="修改~";
        $test->update();
    }
    
    //新增測試 錯誤測試
    $test2=new Commission();
    $test2->link="tttt.xxx";
    //$test2->title="測試標題";
    $test2->content="測試內容";
    $test2->mID="brian60814@gmail.com1";
    $test2->insert();
    

    //刪除測試
    $test3=new Commission();
    if($test3->load(3)){
        $test3->delete();
    }
*/
    //echo("路徑測試 ".__FILE__."<br>");

?>