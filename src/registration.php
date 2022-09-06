<?php

    namespace App;

    use GVM;
    use RequestObject;

    GVM::cors();

    class Registration{
        public static function makeCall(): bool|string
        {
            require_once('GVM.php');
            require_once('RequestObject.php');

            $json = GVM::getData();

            $firstName = new RequestObject($json["firstName"], true);
            $lastName = new RequestObject($json["lastName"], true);
            $userEmail = new RequestObject($json["userEmail"], true);
            $userPassword = new RequestObject($json["userPassword"], true);
            $securityQuestion = new RequestObject($json["securityQuestion"], true);
            $securityAnswer = new RequestObject($json["securityAnswer"], true);

            $parameters = array($firstName, $lastName, $userEmail, $userPassword, $securityQuestion, $securityAnswer);

            $procedureName = "registration";
            return GVM::makeCall($procedureName, $parameters, false);
        }
    }

    echo Registration::makeCall();
?>
