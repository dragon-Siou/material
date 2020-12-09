<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->gallery);

    class GalleryList{
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
                //echo("沒有作品");
                $isSuccess = false;
            }
            else{

                $i=0;
                while($row=$result->fetch_assoc()){
                    
                    $this->data[$i]=new Gallery();

                    $this->data[$i]->ID=$row['gID'];
                    $this->data[$i]->gID=$row['gID'];
                    //$this->data[$i]->gLike = $row['gLike'];
                    $this->data[$i]->link=$row['link'];
                    $this->data[$i]->mID=$row['mID'];
                    $this->data[$i]->title=$row['title'];
                    $this->data[$i]->info=$row['info'];
                    $this->data[$i]->time=substr($row['time'],0 ,16 );
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
            FROM gallery";

            $stmt = $mysqli->prepare($sql);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }

        public function loadFromMember($mID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT *
            FROM gallery
            WHERE mID=? 
            ORDER BY time DESC";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s",$mID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
            
        }

        public function loadFromKey($key){

            $mysqli=(new DBConnetor())->getMysqli();


            $sql="SELECT * 
            FROM gallery AS A
            WHERE A.title LIKE '%{$key}%' OR
            EXISTS(
                SELECT B.tName
                FROM gtag AS B
                WHERE A.gID=B.gID AND B.tName LIKE '%{$key}%'
            )
            ORDER BY time DESC";

            $stmt = $mysqli->prepare($sql);
            //$stmt->bind_param("ss",$key,$key);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }


        
    }
/* 
    //讀取測試
    $trackList=new GalleryList();
   
    if($trackList->loadFromMID("brian60814@gmail.com")){
        foreach($trackList->data as $gallery){
            echo("{$gallery->gID} {$gallery->title} {$gallery->info} <br>");
        }
    }

    if($trackList->loadFromTag("testTag")){
        foreach($trackList->data as $gallery){
            echo("{$gallery->gID} {$gallery->title} {$gallery->info} <br>");
        }
    }



    if($trackList->loadAll()){
        foreach($trackList->data as $gallery){
            echo("{$gallery->gID} {$gallery->title} {$gallery->info} <br>");
        }
    }
    
    */
    //echo("路徑測試 ".__FILE__."<br>");

    // $galleryList=new GalleryList();
    // if($galleryList->loadFromKey("狗")){
    //     foreach($galleryList->data as $gallery){
    //         echo("{$gallery->gID} {$gallery->title} {$gallery->info} <br>");
    //     }
    // }

?>