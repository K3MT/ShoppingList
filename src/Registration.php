<?php
    # Using this namespace for testing purposes
    namespace App;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    # Using the required classes
    use GVM;
    use RequestObject;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    class Registration{
            public static function makeCall()
            {
                # Including the required classes
                require_once('GVM.php');
                require_once('RequestObject.php');
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////

                # Get the "data" variable that stores the passed parameters in a post request using react
                $json = GVM::getData();
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////

                # Getting the post variables
                $firstName = new RequestObject($json["firstName"], true);
                $lastName = new RequestObject($json["lastName"], true);
                $userEmail = new RequestObject($json["userEmail"], true);
                $userPassword = new RequestObject($json["userPassword"], true);
                $securityQuestion = new RequestObject($json["securityQuestion"], true);
                $securityAnswer = new RequestObject($json["securityAnswer"], true);
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////

                # Creating a parameter array and setting the procedure name for the procedure call
                $parameters = array($firstName, $lastName, $userEmail, $userPassword, $securityQuestion, $securityAnswer);
                $procedureName = "registration";
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////

                # Making the procedural call using these parameters
                return GVM::makeCall($procedureName, $parameters, false);
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////
            }
        }

    # Echoing the result
    echo Registration::makeCall();
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>