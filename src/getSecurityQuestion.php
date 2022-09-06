<?php

    namespace App;

    use GVM;
    use RequestObject;

    class GetSecurityQuestion{
        public static function makeCall(): bool|string
        {
            require_once('GVM.php');
            require_once('RequestObject.php');

//            $json = GVM::getData();

            $userID = new RequestObject($_REQUEST["userID"], true);

            $parameters = array($userID);

            $procedureName = "getSecurityQuestion";
            return GVM::makeCall($procedureName, $parameters, false);
        }
    }

    echo GetSecurityQuestion::makeCall();

?>
