<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->member);
    require_once($objectPath->sql);

    $data=array();
    $mID=$_REQUEST["pageMID"];

    $member=new Member();
    $member->load($mID);



    echo(json_encode($member));

?>