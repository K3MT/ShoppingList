<?php
    require_once 'vendor/autoload.php';
    const DEFAULT_USER_ID = 'ebd0ef94-2e9c-11ed-9ff1-062079ffe796';
    const DEFAULT_USER_EMAIL = '2326254@students.wits.ac.za';
    const DEFAULT_SECURITY_ANSWER = 'alright';
    const ITEM_IDS = ['52315eed-282f-11ed-a567-e454e831c10d',
        '5232427d-282f-11ed-a567-e454e831c10d',
        '5243e9cc-282f-11ed-a567-e454e831c10d',
        '523b7f71-282f-11ed-a567-e454e831c10d',
        '524074a7-282f-11ed-a567-e454e831c10d',
        '52449533-282f-11ed-a567-e454e831c10d',
        ];

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
        $bodyContent->userID = DEFAULT_USER_ID;
        $bodyContent->securityAnswer = DEFAULT_SECURITY_ANSWER;
        $bodyContent->newPassword = $faker->word();

        $objContent->data = $bodyContent;

        return $objContent;
      }

      static function getKnownSecurityQuestion(): stdClass
      {
        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userEmail = DEFAULT_USER_EMAIL;

        $objContent->data = $bodyContent;

        return $objContent;
      }

      static function getExistingUser() {
        $objContent = new stdClass();
        
        $bodyContent = new stdClass();
        $bodyContent->userEmail = DEFAULT_USER_EMAIL;
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
        $bodyContent->userImageURL = $faker->imageUrl();
        $bodyContent->userPassword = $faker->iban('NL');
        $bodyContent->securityQuestion = $faker->sentence();
        $bodyContent->securityAnswer = $faker->word();

        $objContent->data = $bodyContent;

        return $objContent;
      }

      public static function getExistingItemContent()
      {
        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = DEFAULT_USER_ID;
        $bodyContent->itemID = array_rand(ITEM_IDS, 1);

        $objContent->data = $bodyContent;

        return $objContent;
      }

      public static function getWrongItemContent()
      {
        $faker = Faker\Factory::create();

        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = $faker->uuid();
        $bodyContent->itemID = $faker->uuid();

        $objContent->data = $bodyContent;

        return $objContent;
      }

      public static function getValidDP()
      {
        $faker = Faker\Factory::create();

        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = DEFAULT_USER_ID;
        $bodyContent->userImageURL = $faker->imageUrl();

        $objContent->data = $bodyContent;

        return $objContent;
      }

      public static function getInvalidDP()
      {
        $faker = Faker\Factory::create();

        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = $faker->uuid();
        $bodyContent->userImageURL = $faker->uuid();

        $objContent->data = $bodyContent;

        return $objContent;
      }
    }