<?php
    namespace App;

    use GVM;
    use RequestObject;

    GVM::cors();

    class Login{
        public static function makeCall(): bool|string
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
