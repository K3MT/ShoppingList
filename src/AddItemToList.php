<?php
    # Using this namespace for testing purposes
    namespace App;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    # Using the required classes
    use GVM;
    use RequestObject;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    class AddItemToList{
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
            $itemID = new RequestObject($json["itemID"], true);
            $typeTemplate = new RequestObject($json["typeTemplate"], false);
            $typeCart = new RequestObject($json["typeCart"], false);
            $typePublic = new RequestObject($json["typePublic"], false);
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            # Creating a parameter array and setting the procedure name for the procedure call
            $parameters = array($userID, $itemID, $typeTemplate,$typeCart, $typePublic);
            $procedureName = "addItemToList";
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            # Making the procedural call using these parameters
            return GVM::makeCall($procedureName, $parameters, false);
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
    }

    # Echoing the result
    echo AddItemToList::makeCall();
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
