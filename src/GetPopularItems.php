<?php
    # Using this namespace for testing purposes
    namespace App;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    # Using the required classes
    use App\GVM;
    use App\RequestObject;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    class GetPopularItems{
        public static function makeCall()
        {
            # Including the required classes
            require_once('GVM.php');
            require_once('RequestObject.php');
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            # Creating a parameter array and setting the procedure name for the procedure call
            $parameters = array();
            $procedureName = "getPopularItems";
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            # Making the procedural call using these parameters
            return GVM::makeCall($procedureName, $parameters, false);
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
    }

    // @codeCoverageIgnoreStart
    # Echoing the result if not in test mode
    if (!(defined('TEST_MODE') && defined('INPUT_TEST_FILE') && TEST_MODE)) {
        echo GetPopularItems::makeCall();
    }
    // @codeCoverageIgnoreEnd
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
