<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);

    class Comment{
        public $cID;
        public $gID;
        public $mID;
        public $cTime;
        public $content;
        public $rID;
        //設定用
        public $userName;
        public $pLink;

        public function __construct()
        {
            $this->cID=null;
            $this->gID=null;
            $this->mID=null;
            $this->cTime=null;
            $this->content=null;
            $this->rID=null;
        }

        public function load($cID){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT * 
            FROM comment
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

                $this->cID=$row['cID'];
                $this->gID=$row['gID'];
                $this->mID=$row['mID'];
                $this->cTime=substr($row['cTime'],0 ,16 );
                $this->content=$row['content'];
                $this->rID=$row['rID'];

                //echo("{$this->cID} {$this->link}");
            }

            $result->free();
            $mysqli->close();

            return $isSuccess;
        }

        //檢查資料
        private function checkData(){

            if($this->gID == null){
                throw new Exception("留言的作品ID為空");
            }
            if($this->mID == null){
                throw new Exception("留言的使用者ID為空");
            }
            if($this->content == null){
                throw new Exception("留言內容為空");
            }
            
        }

        //更新資料
        public function update(){

            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();
            
            
            
            $sql = "UPDATE comment  
            SET gID=?, mID=?, cTime=?, content=?, rID=?
            WHERE ? = cID";

            $stmt=$mysqli->prepare($sql);
            $stmt->bind_param("isssii", $this->gID, $this->mID, $this->cTime, 
                $this->content, $this->rID, $this->cID);
            $stmt->execute();

            $mysqli->close();
        }

        //新增
        public function insert(){

            //檢查
            $this->checkData();

            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "INSERT INTO comment(gID,mID,content,rID) 
            VALUES(?,?,?,?);";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("issi", $this->gID, $this->mID, $this->content, $this->rID);
            $stmt->execute();

            $mysqli->close();

        }

        //刪除
        public function delete(){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql = "DELETE FROM comment  
            WHERE ? = cID;";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $this->cID);
            $stmt->execute();

            $mysqli->close();
        }

    }

    /*
    //更新測試
    $test=new Comment();
    if($test->load(2)){
        $test->content="修改~";
        $test->update();
    }

    //新增測試 錯誤測試
    $test2=new Comment();
    $test2->gID=5;
    $test2->mID="brian60814@gmail.com";
    $test2->content="測試內容";
    $test2->insert();


    //刪除測試
    $test3=new Comment();
    if($test3->load(3)){
        $test3->delete();
    }
*/
    //echo("路徑測試 ".__FILE__."<br>");

?>