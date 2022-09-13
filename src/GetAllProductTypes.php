<?php

namespace App;

use GVM;

class GetAllProductTypes
{
    public static function makeCall()
    {
        require_once('GVM.php');

        $parameters = array();

        $procedureName = "getAllProductTypes";
        return GVM::makeCall($procedureName, $parameters, false);
    }
}

echo GetAllProductTypes::makeCall();

?>
