<?php
namespace App;

use GVM;
use RequestObject;

class UpdateAboutMe{
    public static function makeCall()
    {
        require_once('GVM.php');
        require_once('RequestObject.php');

        $json = GVM::getData();

        $userID = new RequestObject($json["userID"], true);
        $userAboutMe = new RequestObject($json["userAboutMe"], true);

        $parameters = array($userID, $userAboutMe);

        $procedureName = "updateAboutMe";

        return GVM::makeCall($procedureName, $parameters, false);
    }
}

    echo UpdateAboutMe::makeCall();
?>
