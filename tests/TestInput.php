<?php
    require_once 'vendor/autoload.php';

    class TestInput {

      static function log($message) {
        $logFile = fopen('log.txt', 'a');

        fwrite($logFile, $message."\n\n");
        fclose($logFile);
      }
      static function writeInput($fName, $strContent) {
        $_SERVER["REQUEST_METHOD"] = "POST";

        $fileWriter = fopen($fName, "w");

        fwrite($fileWriter, $strContent);

        fclose($fileWriter);
      }

      static function getResetPasswordInput(): stdClass
      {
        $faker = Faker\Factory::create();
        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = 'ebd0ef94-2e9c-11ed-9ff1-062079ffe796';
        $bodyContent->securityAnswer = 'alright';
        $bodyContent->newPassword = $faker->word();

        $objContent->data = $bodyContent;

        return $objContent;
      }

      static function getKnownSecurityQuestion(): stdClass
      {
        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userEmail = '2326254@students.wits.ac.za';

        $objContent->data = $bodyContent;

        return $objContent;
      }

      static function getExistingUser() {
        $objContent = new stdClass();
        
        $bodyContent = new stdClass();
        $bodyContent->userEmail = '2326254@students.wits.ac.za';
        $bodyContent->userPassword = 'root';

        $objContent->data = $bodyContent;

        return $objContent;
      }

      static function getNonExistingUser() {
        $faker = Faker\Factory::create();

        $objContent = new stdClass();
        
        $bodyContent = new stdClass();
        $bodyContent->userEmail = $faker->email();
        $bodyContent->userPassword = $faker->iban('NL');


        $objContent->data = $bodyContent;

        return $objContent;
      }

      static function getNewUser()
      {

        $faker = Faker\Factory::create();

        $objContent = new stdClass();
        
        $bodyContent = new stdClass();
        $bodyContent->firstName = $faker->firstName();
        $bodyContent->lastName = $faker->lastName();
        $bodyContent->userEmail = $faker->email();
        $bodyContent->userPassword = $faker->iban('NL');
        $bodyContent->securityQuestion = $faker->sentence();
        $bodyContent->securityAnswer = $faker->word();

        $objContent->data = $bodyContent;

        return $objContent;
      }
    }