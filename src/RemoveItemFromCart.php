<?php
namespace App;

use GVM;
use RequestObject;

class RemoveItemFromCart{
    public static function makeCall()
    {
        require_once('GVM.php');
        require_once('RequestObject.php');

        $json = GVM::getData();

        $userID = new RequestObject($json["userID"], true);
        $itemID = new RequestObject($json["itemID"], true);
        $parameters = array($userID, $itemID);
        $procedureName = "removeItemFromCart";
        return GVM::makeCall($procedureName, $parameters, false);
    }
}

echo RemoveItemFromCart::makeCall();
?>
