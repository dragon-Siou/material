<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->member);

    class SignModel{
        public $account;
        public $password;
        public $errMsg;

        public function __construct()
        {
            $this->account=null;
            $this->password=null;
            $this->errMsg="SignModel:<br>";
        }

        private function checkData(){
            
            //是否為空
            if(empty($this->account)){
                $this->errMsg.="帳號為空<br>";
                return false;
            }
            if(empty($this->password)){
                $this->errMsg.="密碼為空<br>";
                return false;
            }

            //資料限制
            //資料正確性

            return true;
        }
        
        public function sign(){

            if(!$this->checkData()){
                return false;
            }

            $member=new Member();
            
            //如果不能載入
            if(!$member->load($this->account)){
                $this->errMsg.="帳號不存在<br>";
                return false;
            }

            if(!$member->comparePassword($this->password)){
                $this->errMsg.="密碼不正確<br>";
                return false;
            }

            return true;
        }

    }

    //echo("路徑測試 ".__FILE__."<br>");
?>