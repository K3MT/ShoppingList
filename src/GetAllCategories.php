<?php

namespace App;

use GVM;

class GetAllCategories
{
    public static function makeCall()
    {
        require_once('GVM.php');

        $parameters = array();

        $procedureName = "getAllCategories";
        return GVM::makeCall($procedureName, $parameters, false);
    }
}

echo GetAllCategories::makeCall();

?>
