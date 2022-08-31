<?php
    require_once('RequestObject.php');
    require_once('GVM.php');

    $userID = new RequestObject($_REQUEST["userID"], true);
    $securityAnswer = new RequestObject($_REQUEST["securityAnswer"], true);
    $newPassword = new RequestObject($_REQUEST["newPassword"], true);

    $parameters = array($userID, $securityAnswer, $newPassword);

    $procedureName = "resetPassword";
    GVM::makeCall($procedureName, $parameters, false);
?>
