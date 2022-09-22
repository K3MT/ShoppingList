<?php

    namespace App;

    use GVM;

    class GetDefaultImageLink
    {
        public static function makeCall()
        {
            require_once('GVM.php');

            $parameters = array();

            $procedureName = "getDefaultImageLink";
            return GVM::makeCall($procedureName, $parameters, false);
        }
    }

    echo GetDefaultImageLink::makeCall();

?>
