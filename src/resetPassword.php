<?php

    namespace App;

    use GVM;
    use RequestObject;

class ResetPassword{
        public static function makeCall(): bool|string
        {
            require_once('GVM.php');
            require_once('RequestObject.php');

            $json = GVM::getData();

            $userID = new RequestObject($json["userID"], true);
            $securityAnswer = new RequestObject($json["securityAnswer"], true);
            $newPassword = new RequestObject($json["newPassword"], true);

            $parameters = array($userID, $securityAnswer, $newPassword);

            $procedureName = "resetPassword";

            return GVM::makeCall($procedureName, $parameters, false);
        }

    }

    echo ResetPassword::makeCall();
?>
