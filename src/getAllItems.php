<?php

    namespace App;

    use GVM;

    GVM::cors();

    class GetAllItems
    {
        public static function makeCall(): bool|string
        {
            require_once('GVM.php');

            $parameters = array();

            $procedureName = "getAllItems";
            return GVM::makeCall($procedureName, $parameters, false);
        }
    }

    echo GetAllItems::makeCall();

?>
