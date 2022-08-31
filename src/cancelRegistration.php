<?php
    require_once('RequestObject.php');
    require_once('GVM.php');

    $userID = new RequestObject($_REQUEST["userID"], true);

    $parameters = array($userID);

    $procedureName = "cancelRegistration";
    GVM::makeCall($procedureName, $parameters, false);
?>
