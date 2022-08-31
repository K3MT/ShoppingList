<?php
    require_once('RequestObject.php');
    require_once('GVM.php');

    $firstName = new RequestObject($_REQUEST["firstName"], true);
    $lastName = new RequestObject($_REQUEST["lastName"], true);
    $userEmail = new RequestObject($_REQUEST["userEmail"], true);
    $userPassword = new RequestObject($_REQUEST["userPassword"], true);
    $securityQuestion = new RequestObject($_REQUEST["securityQuestion"], true);
    $securityAnswer = new RequestObject($_REQUEST["securityAnswer"], true);

    $parameters = array($firstName, $lastName, $userEmail, $userPassword, $securityQuestion, $securityAnswer);

    $procedureName = "registration";
    GVM::makeCall($procedureName, $parameters, false);
?>
