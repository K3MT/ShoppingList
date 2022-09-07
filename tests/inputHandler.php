<?php
    require_once 'vendor/autoload.php';

/**
 * @codeCoverageIgnore
 */
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

      static function getResetPasswordInput() {
        $faker = Faker\Factory::create();
        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = 'ebd0ef94-2e9c-11ed-9ff1-062079ffe796';
        $bodyContent->securityAnswer = 'alright';
        $bodyContent->newPassword = $faker->password(10, 15);

        $objContent->data = $bodyContent;

        return $objContent;
      }

      static function getKnownSecurityQuestion() {
        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = '2ae10548-2834-11ed-a567-e454e831c10d';

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
        $bodyContent->userPassword = $faker->password(10, 15);

        $objContent->data = $bodyContent;

        return $objContent;
      }

      static function getNewUser() {

        $faker = Faker\Factory::create();

        $objContent = new stdClass();
        
        $bodyContent = new stdClass();
        $bodyContent->firstName = $faker->firstName();
        $bodyContent->lastName = $faker->lastName();
        $bodyContent->userEmail = $faker->email();
        $bodyContent->userPassword = $faker->password(10, 15);
        $bodyContent->securityQuestion = $faker->sentence();
        $bodyContent->securityAnswer = $faker->word();

        $objContent->data = $bodyContent;

        return $objContent;
      }
    }