<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($controllerPath->registeredController);

    class RegisteredView{ 
        private $registeredController;

        public function __construct()
        {
            $this->registeredController=new RegisteredController();
            //echo($this->registeredController->pathMsg);
            //echo($this->registeredController->errMsg);
        }
    }

    //echo("路徑測試 ".__FILE__."<br>");
?>