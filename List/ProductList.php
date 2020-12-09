<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->product);


    class ProductList{
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
                //echo("沒有商品");
                $isSuccess = false;
            }
            else{

                $i=0;
                while($row=$result->fetch_assoc()){
                    
                    $this->data[$i]=new Product();

                    $this->data[$i]->ID=$row['pID'];
                    $this->data[$i]->pID=$row['pID'];
                    $this->data[$i]->link=$row['link'];
                    $this->data[$i]->title=$row['title'];
                    $this->data[$i]->content=$row['content'];
                    $this->data[$i]->price=$row['price'];
                    $this->data[$i]->time=substr($row['time'],0 ,16 );
                    $this->data[$i]->enable=$row['enable'];
                    $this->data[$i]->mID=$row['mID'];
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
            FROM product 
            WHERE enable='Y'";

            $stmt = $mysqli->prepare($sql);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }

        public function loadFromMember($mID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT *
            FROM product
            WHERE mID=? AND enable='Y' 
            ORDER BY time DESC";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s",$mID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }

        public function loadFromKey($key){

            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT * 
            FROM product AS A
            WHERE enable='Y' AND A.title LIKE '%{$key}%' OR
            EXISTS(
                SELECT B.tName
                FROM ptag AS B
                WHERE A.pID=B.pID AND B.tName LIKE '%{$key}%'
            )
            ORDER BY time DESC";

            $stmt = $mysqli->prepare($sql);
            //$stmt->bind_param("s",$tName);
            $stmt->execute();

            return $this->load($mysqli,$stmt);
        }

        //注意，這個會取得紀錄裡面的商品價格，而不是現在的
        public function loadFromTransaction($mID){
            $mysqli=(new DBConnetor())->getMysqli();

            $sql="SELECT A.pID, A.link, A.title, A.content, B.price, B.tTime AS time, A.enable, A.mID
            FROM product AS A, transaction AS B
            WHERE A.pID=B.pID AND B.mID=? AND enable='Y'";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s",$mID);
            $stmt->execute();

            return $this->load($mysqli,$stmt);

        }
    }

/*
    //讀取測試
    $productList=new ProductList();
    
    if($productList->loadFromMID("brian60814@gmail.com")){
        foreach($productList->data as $product){
            echo("{$product->pID} {$product->title} {$product->content} <br>");
        }
    }


    if($productList->loadFromTag("testTag")){
        foreach($productList->data as $product){
            echo("{$product->pID} {$product->title} {$product->content} <br>");
        }
    }
    
    

    if($productList->loadFromTransaction("brian60814@gmail.com")){
        foreach($productList->data as $product){
            echo("{$product->pID} {$product->title} {$product->content} 
            {$product->price} {$product->time} <br>");
        }
    }

    if($productList->loadAll()){
        foreach($productList->data as $product){
            echo("{$product->pID} {$product->title} {$product->content} 
            {$product->price} {$product->time} <br>");
        }
    }
    */
    //echo("路徑測試 ".__FILE__."<br>");
?>