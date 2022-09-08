<?php

    namespace App;

    use GVM;
    use RequestObject;

    class GetSecurityQuestion{
        public static function makeCall()
        {
            require_once('GVM.php');
            require_once('RequestObject.php');

            $json = GVM::getData();

            $userEmail = new RequestObject($json["userEmail"], true);

            $parameters = array($userEmail);

            $procedureName = "getSecurityQuestion";
            return GVM::makeCall($procedureName, $parameters, false);
        }
    }

    echo GetSecurityQuestion::makeCall();

?>
