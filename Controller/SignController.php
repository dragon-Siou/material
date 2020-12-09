<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($modelPath->signModel);

    class SignController{
        private $signModel;
        private const account="account";
        private const password="password";
        private const signButton="signButton";
        public $errMsg;
        public $pathMsg;
        public $scriptContent;

        public function __construct()
        {
            $this->signModel=new SignModel();
            $this->pathMsg="SignController pathMsg:<br>";
            $this->errMsg="SignController errMsg:<br>";
            $this->scriptContent="";

            //判斷有沒有Post
            if($this->isPostDataExist()){
                //登入
                $this->pathMsg.="登入<br>";
                $this->setPostData();
                $this->sign();
            }
            else{
                $this->pathMsg.="非登入狀態<br>";
            }

            //$this->pathMsg.=$this->signModel->errMsg;
        }

        private function isPostDataExist(){
            //連button的post都沒抓到 這好像會錯
            /*
            if(!isset($_POST[SignController::signButton])){
                $this->errMsg.="button為null(沒送表單)<br>";
                return false;
            }*/

            if(!isset($_POST[SignController::account])){
                $this->errMsg.="帳號為null<br>";
                return false;
            }

            if(!isset($_POST[SignController::password])){
                $this->errMsg.="密碼為null<br>";
                return false;
            }
            return true;
        }

        private function setPostData(){
            $this->signModel->account=
                htmlspecialchars($_POST[SignController::account],ENT_QUOTES);

            $this->signModel->password=
                htmlspecialchars($_POST[SignController::password],ENT_QUOTES);

        }

        private function sign(){
            if($this->signModel->sign()){
                $this->pathMsg.="登入成功<br>";
                
                //設定session
                session_start();
                $_SESSION["memberID"]=$this->signModel->account;
                
                //跳轉頁面
                $webPath=new WebPath();
                $webPath->location();
                //echo($webPath->person);
                header($webPath->index);

                echo($_SESSION["memberID"]);
            }
            else{
                //登入失敗
                $this->pathMsg.="登入失敗<br>";
                //$this->pathMsg.=$this->signModel->errMsg;
                $this->scriptContent="<script>
                alert(\"登入失敗\");
                </script>";
            }
        }
    }

    //echo("路徑測試 ".__FILE__."<br>");
?>