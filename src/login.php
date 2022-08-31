<?php
    require_once('RequestObject.php');
    require_once('GVM.php');

    $userEmail = new RequestObject($_REQUEST["userEmail"], true);
    $userPassword = new RequestObject($_REQUEST["userPassword"], true);
    $parameters = array($userEmail, $userPassword);
    $procedureName = "login";
    GVM::makeCall($procedureName, $parameters, false);
?>
