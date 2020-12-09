<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->member);

    class RegisteredModel{
        public $account;
        public $userName;
        public $password;
        public $confirmPassword;
        public $errMsg;

        public function __construct()
        {
            $this->account=null;
            $this->userName=null;
            $this->password=null;
            $this->confirmPassword=null;
            $this->errMsg="RegisteredModel:<br>";
        }

        //檢查資料
        public function checkData(){
            //失敗傳回false
            //是否為空
            if(empty($this->account)){
                $this->errMsg.="帳號為空<br>";
                return false;
            }
            if(empty($this->userName)){
                $this->errMsg.="帳號為空<br>";
                return false;
            }
            if(empty($this->password)){
                $this->errMsg.="密碼為空<br>";
                return false;
            }
            if(empty($this->confirmPassword)){
                $this->errMsg.="確認密碼為空<br>";
                return false;
            }

            //資料值限制
            //判斷帳號是否不合法
            if(preg_match("/[^ \w @ .]/",$this->account)){
                $this->errMsg.="帳號含有不合法字元<br>";
                return false;
            }

            //判斷密碼是否不合法
            if(preg_match("/[ \W ]/",$this->password)){
                $this->errMsg.="密碼含有不合法字元<br>";
                return false;
            }


            //長度限制


            //資料正確性
            if($this->password != $this->confirmPassword){
                $this->errMsg.="確認密碼不一致<br>";
            }

                   
            return true;
        }


        //註冊
        public function registered(){

            //先把頭尾空白去掉
            $this->account=trim($this->account);
            $this->userName=trim($this->userName);
            $this->password=trim($this->password);
            $this->confirmPassword=trim($this->confirmPassword);

            //檢查資料
            if(!$this->checkdata()){
                //echo("資料為空");
                return false;
            }


            //檢查通過
            $member=new Member();
            $member->mID=$this->account;

            //註冊過了
            if($member->isExist()){
                $this->errMsg.="帳號已被註冊<br>";
                return false;
            }

            $member->userName=$this->userName;
            $member->password=$this->password;
            $member->setEnable(true);
            $member->insert();

            return true;
        }
    }

    //echo("路徑測試 ".__FILE__."<br>");
?>