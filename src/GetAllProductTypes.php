<?php
    # Using this namespace for testing purposes
    namespace App;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    # Using the required classes
    use App\GVM;
    use RequestObject;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    class GetAllProductTypes
    {
        public static function makeCall()
        {
            # Including the required classes
            require_once('GVM.php');
            require_once('RequestObject.php');
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            # Get the "data" variable that stores the passed parameters in a post request using react
            $json = GVM::getData();
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            # Creating a parameter array and setting the procedure name for the procedure call
            $parameters = array();
            $procedureName = "getAllProductTypes";
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            # Making the procedural call using these parameters
            return GVM::makeCall($procedureName, $parameters, false);
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
    }
    # Echoing the result if not in test mode
    if (!(defined('TEST_MODE') && defined('INPUT_TEST_FILE') && TEST_MODE)) {
        echo GetAllProductTypes::makeCall();
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
