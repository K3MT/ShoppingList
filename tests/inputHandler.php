<?php
    require_once 'vendor/autoload.php';

    
    $filename = "input.txt";
    $reqObject = new stdClass();
    
    class TestInput {

      static function getFaker() {
        return Faker\Factory::create();
      }

      static function writeInput($fName, $strContent) {
        $_SERVER["REQUEST_METHOD"] = "POST";

        $fileWriter = fopen($fName, "w");

        fwrite($fileWriter, $strContent);

        fclose($fileWriter);
      }
    }