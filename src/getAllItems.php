<?php
    require_once('RequestObject.php');
    require_once('GVM.php');

    $parameters = array();

    $procedureName = "getAllItems";
    GVM::makeCall($procedureName, $parameters, false);
?>
