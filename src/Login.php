<?php
    namespace App;

    use GVM;
    use RequestObject;

class Login{
        public static function makeCall()
        {
            require_once('GVM.php');
            require_once('RequestObject.php');

            $json = GVM::getData();

            $userEmail = new RequestObject($json["userEmail"], true);
            $userPassword = new RequestObject($json["userPassword"], true);
            $parameters = array($userEmail, $userPassword);
            $procedureName = "login";
            return GVM::makeCall($procedureName, $parameters, false);
        }
    }

    echo Login::makeCall();
?>
