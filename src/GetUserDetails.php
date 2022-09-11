<?php
namespace App;

use GVM;
use RequestObject;

class GetUserDetails{
    public static function makeCall()
    {
        require_once('GVM.php');
        require_once('RequestObject.php');

        $json = GVM::getData();

        $userID = new RequestObject($json["userID"], true);
        $parameters = array($userID);
        $procedureName = "getUserDetails";
        return GVM::makeCall($procedureName, $parameters, false);
    }
}

    echo GetUserDetails::makeCall();
?>
