<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($controllerPath->signController);

    class SignView{
        private $signController;

        public function __construct()
        {
            $this->signController=new SignController();
            //echo($this->signController->pathMsg);
            //echo($this->signController->errMsg);
            //echo("仔入");
        }

        public function printScript(){
            echo($this->signController->scriptContent);
            /*echo("<script>
            alert(\"登入失敗\");
            </script>");*/
        }
    }

    //echo("路徑測試 ".__FILE__."<br>");
?>