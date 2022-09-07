<?php

    namespace App;

    use GVM;

    class GetAllItems
    {
        public static function makeCall()
        {
            require_once('GVM.php');

            $parameters = array();

            $procedureName = "getAllItems";
            return GVM::makeCall($procedureName, $parameters, false);
        }
    }

    echo GetAllItems::makeCall();

?>
