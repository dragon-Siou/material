<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($modelPath->registeredModel);

    class RegisteredController{
        private $registeredModel;
        private const account="account";
        private const userName="userName";
        private const password="password";
        private const confirmPassword="confirmPassword";
        public $pathMsg;
        public $errMsg;

        public function __construct()
        {
            $this->pathMsg="RegisteredController pathMsg:<br>";
            $this->errMsg="RegisteredController errMsg:<br>";
            $this->registeredModel=new RegisteredModel();

            //有post
            if($this->isPostDataExist()){
                $this->pathMsg.="註冊<br>";
                $this->setPostData();
                $this->registered();
            }
            else{
                $this->pathMsg.="不是註冊<br>";
            }
            
            //echo($this->registeredModel->errMsg);
        }

        private function isPostDataExist(){

            if(!isset($_POST[RegisteredController::account])){
                $this->errMsg.="帳號為null <br>";
                return false;
            }
            if(!isset($_POST[RegisteredController::userName])){
                $this->errMsg.="名稱為null <br>";
                return false;
            }
            if(!isset($_POST[RegisteredController::password])){
                $this->errMsg.="密碼為null <br>";
                return false;
            }
            if(!isset($_POST[RegisteredController::confirmPassword])){
                $this->errMsg.="確認為null <br>";
                return false;
            }
            

            return true;
        }

        private function setPostData(){

            $this->registeredModel->account=
                htmlspecialchars($_POST[RegisteredController::account],ENT_QUOTES);

            $this->registeredModel->userName=
                htmlspecialchars($_POST[RegisteredController::userName],ENT_QUOTES);

            $this->registeredModel->password=
                htmlspecialchars($_POST[RegisteredController::password],ENT_QUOTES);

            $this->registeredModel->confirmPassword=
                htmlspecialchars($_POST[RegisteredController::confirmPassword],ENT_QUOTES);
        }

        private function registered(){
            if($this->registeredModel->registered()){
                $this->pathMsg.="註冊成功<br>";
                //設定session
                session_start();
                $_SESSION["memberID"]=$this->registeredModel->account;
                //跳轉頁面
                $webPath=new WebPath();
                $webPath->location();
                //echo($webPath->person);
                header($webPath->index);
            }
            else{
                $this->pathMsg.="註冊失敗<br>";
                $this->errMsg.="註冊失敗<br>";
                //echo($this->registeredModel->errMsg);
            }
        }
        

         

    }

    //echo("路徑測試 ".__FILE__."<br>");
?>