<?php

class GVM
{
    public static function getLink(){
        $hostname = "localhost";
        $username = "root";
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
        echo json_encode($output);

        if ($echoCall){
            echo $query;
        }
    }
}