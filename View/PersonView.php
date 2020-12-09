<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($controllerPath->personController);

    class PersonView{
        private $personController;

        function __construct()
        {
            $this->personController=new PersonController();
        }

        
    }

    //echo("路徑測試 ".__FILE__."<br>");
?>