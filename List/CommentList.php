<?php

    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->comment);
    require_once($objectPath->member);

    class CommentList{
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
                //echo("沒有留言");
                $isSuccess = false;
            }
            else{

                $i=0;
                while($row=$result->fetch_assoc()){
                    
                    $this->data[$i]=new Comment();

                    $this->data[$i]->cID=$row['cID'];
                    $this->data[$i]->gID=$row['gID'];
                    $this->data[$i]->mID=$row['mID'];
                    $this->data[$i]->cTime=substr($row['cTime'],0 ,16 );
                    $this->data[$i]->content=$row['content'];
                    $this->data[$i]->rID=$row['rID'];

                    //載入使用者姓名
                    $member=new Member();
                    $member->load($row['mID']);

                    $this->data[$i]->userName=$member->userName;
                    $this->data[$i]->pLink=$member->pLink;

                    $i++;
                }
                

                //echo("{$row['mID']} {$row['userName']} {$row['password']}");
            }

            $result->free();
            $mysqli->close();
            return $isSuccess;
        }

        public function loadFromGallery($gID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT * 
            FROM comment
            WHERE gID=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i",$gID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }

        public function loadFromReply($cID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT * 
            FROM comment
            WHERE rID=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i",$cID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }

    }

/*   
    $commentList=new CommentList();

    if($commentList->loadFromGallery(5)){
        foreach($commentList->data as $comment){
            echo("{$comment->cID} {$comment->content} <br>");
        }
    }
   

    if($commentList->loadFromReply(2)){
        foreach($commentList->data as $comment){
            echo("{$comment->cID} {$comment->content} {$comment->rID} <br>");
        }
    }
 */
    //echo("路徑測試 ".__FILE__."<br>");
?>