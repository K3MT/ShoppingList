<?php

namespace App;

use GVM;
use RequestObject;

class UserExists{
    public static function makeCall()
    {
        require_once('GVM.php');
        require_once('RequestObject.php');

        $json = GVM::getData();

        $userEmail = new RequestObject($json["userEmail"], true);

        $parameters = array($userEmail);

        $procedureName = "userExists";
        return GVM::makeCall($procedureName, $parameters, false);
    }
}

echo UserExists::makeCall();

?>
