<?php
    require_once('RequestObject.php');
    require_once('GVM.php');

    $userID = new RequestObject($_REQUEST["userID"], true);
    $authCode = new RequestObject($_REQUEST["authCode"], false);

    $parameters = array($authCode, $userID);

    $procedureName = "completeRegistration";
    GVM::makeCall($procedureName, $parameters, false);
?>
