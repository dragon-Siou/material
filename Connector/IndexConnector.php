<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($listPath->galleryList);
    require_once($listPath->productList);
    require_once($listPath->commissionList);
    require_once($modelPath->loadDataModel);

    $data=new ArrayObject();
    //$data["debug"]="失敗";
    
    //有type
    if(isset($_REQUEST["searchType"])){
        
        $key="";
        if(isset($_REQUEST["search"])){
            $key=$_REQUEST["search"];
        }

        
        //$data["debug"]=$key;
        
        /*
        switch($_REQUEST["searchType"]){

            case "gallery":
                $galleryList=new GalleryList();
                if($galleryList->loadFromKey($key)){
                    $data=$galleryList->data;
                }

                break;

            case "product":
                $productList=new ProductList();
                if($productList->loadFromKey($key)){
                    $data=$productList->data;
                }
                
                break;

            case "commission":
                $commissionList=new CommissionList();
                if($commissionList->loadFromKey($key)){
                    $data=$commissionList->data;
                }

                break;
        }*/

        $loadDataModel=new LoadDataModel($_REQUEST["searchType"]);
        $loadDataModel->loadFromKey($key);
        $data=$loadDataModel->data;

    }

    echo(json_encode($data));

?>
