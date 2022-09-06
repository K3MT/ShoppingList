<?php

class GVM
{
    public static function addHeaders()
    {
        header('Access-Control-Allow-Origin: *');
//        header('Access-Control-Allow-Methods: GET, POST');
//        header("Access-Control-Allow-Headers: X-Requested-With");
        header('Content-Type: application/json');
    }

    public static function getData(){
        $dataLabel = "data";
        $inputFile = "php://input";
        return json_decode(file_get_contents($inputFile), true)[$dataLabel];
    }

    public static function getLink(){
        $hostname = "k3mt-db.csig7fwo3yso.af-south-1.rds.amazonaws.com";
        $username = "Kaytee";
        $password = "milktartsrgood";
        $database = "local_kemt";

        return mysqli_connect($hostname, $username, $password, $database);
    }

    public static function quotify($string){
        return "\"" . $string . "\"";
    }

    public static function buildParameters($parameters){
        $result = "";
        for ($i = 0; $i < count($parameters); $i++){
            $requestObject = $parameters[$i];

            if ($requestObject instanceof RequestObject){
                if ($requestObject->quotify){
                    $result .= self::quotify($requestObject->content);
                }
                else{
                    $result .= $requestObject->content;
                }
            }

            if ($i != count($parameters) - 1){
                $result .= ", ";
            }
        }

        return $result;
    }

    public static function makeCall($procedureName, $parameters, $echoCall){
        GVM::addHeaders();
        $link = GVM::getLink();

        $output=array();

        $query = "call " . $procedureName . "(" . GVM::buildParameters($parameters) . ");";
        if ($r = mysqli_query($link, $query))
        {
            if ($r instanceof mysqli_result){
                while ($row=$r->fetch_assoc()){
                    $output[]=$row;
                }
            }
        }
        mysqli_close($link);

        if ($echoCall){
            echo $query;
        }

        return json_encode($output);
    }
}