<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->member);
    require_once($objectPath->sql);

    $member=new Member();
    $member->load($_REQUEST["mID"]);

    //確認舊密碼正確
    if($member->comparePassword($_REQUEST["oldPassword"])){
        //確認使用者輸入的新密碼依樣
        //修改密碼
        if($_REQUEST["newPassword"] == $_REQUEST["confrimPassword"]){
            $member->password=$_REQUEST["newPassword"];
            $member->update();
            echo("修改密碼成功");
        }
        else{
            echo("新密碼不一致");
        }
    }
    else{
        echo("密碼錯誤");
    }
?>