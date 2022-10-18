<?php
    # Using this namespace for testing purposes
    namespace App;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    # Using the required classes
    use App\GVM;
    use App\RequestObject;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    class GetFollowRequests{
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
            $userID = new RequestObject($json["userID"], true);
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            # Creating a parameter array and setting the procedure name for the procedure call
            $parameters = array($userID);
            $procedureName = "getFollowRequests";
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            # Making the procedural call using these parameters
            return GVM::makeCall($procedureName, $parameters, false);
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
    }

    // @codeCoverageIgnoreStart
    # Echoing the result if not in test mode
    if (!(defined('TEST_MODE') && defined('INPUT_TEST_FILE') && TEST_MODE)) {
        echo GetFollowRequests::makeCall();
    }
    // @codeCoverageIgnoreEnd
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>