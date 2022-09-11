<?php
namespace App;

use GVM;
use RequestObject;

class UploadProfilePicture{
    public static function makeCall()
    {
        require_once('GVM.php');
        require_once('RequestObject.php');

        $json = GVM::getData();

        $userID = new RequestObject($json["userID"], true);
        $userImageURL = new RequestObject($json["userImageURL"], true);

        $parameters = array($userID, $userImageURL);

        $procedureName = "uploadProfilePicture";

        return GVM::makeCall($procedureName, $parameters, false);
    }
}

    echo UploadProfilePicture::makeCall();
?>
