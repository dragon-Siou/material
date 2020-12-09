<?php
    require_once(dirname(__FILE__)."/Path.php");
    require_once($objectPath->gallery);

    $data=array();

    $gallery=new Gallery();
    $gallery->load("11");

    $data["showData"]=$gallery;

    echo(json_encode($data));
?>