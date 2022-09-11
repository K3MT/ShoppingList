<?php
namespace App;

use GVM;
use RequestObject;

class AddItemToCart{
    public static function makeCall()
    {
        require_once('GVM.php');
        require_once('RequestObject.php');

        $json = GVM::getData();

        $userID = new RequestObject($json["userID"], true);
        $itemID = new RequestObject($json["itemID"], true);
        $parameters = array($userID, $itemID);
        $procedureName = "addItemToCart";
        return GVM::makeCall($procedureName, $parameters, false);
    }
}

echo AddItemToCart::makeCall();
?>
