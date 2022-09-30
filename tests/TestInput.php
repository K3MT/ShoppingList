<?php

use Faker\Factory;

require_once 'vendor/autoload.php';
    const DEFAULT_USER_ID = 'ebd0ef94-2e9c-11ed-9ff1-062079ffe796';
    const DEFAULT_IMAGE_URL = 'http://lorempixel.com/640/480/transport';
    const DEFAULT_USER_EMAIL = '2326254@students.wits.ac.za';
    const DEFAULT_SECURITY_ANSWER = 'alright';
    const DEFAULT_ITEM_ID = '52315eed-282f-11ed-a567-e454e831c10d';
    const ITEM_IDS = ['52315eed-282f-11ed-a567-e454e831c10d',
        '5232427d-282f-11ed-a567-e454e831c10d',
        '5243e9cc-282f-11ed-a567-e454e831c10d',
        '523b7f71-282f-11ed-a567-e454e831c10d',
        '524074a7-282f-11ed-a567-e454e831c10d',
        '52449533-282f-11ed-a567-e454e831c10d',
        ];



    class TestInput {
      static string $usedItemID;

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

      static function getValidResetPasswordInput(): stdClass
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
      static function getInvalidResetPasswordInput(): stdClass
      {
        $faker = Faker\Factory::create();
        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = $faker->uuid();
        $bodyContent->securityAnswer = DEFAULT_SECURITY_ANSWER;
        $bodyContent->newPassword = $faker->word();

        $objContent->data = $bodyContent;

        return $objContent;
      }

      static function getValidUserEmail(): stdClass
      {
        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userEmail = DEFAULT_USER_EMAIL;

        $objContent->data = $bodyContent;

        return $objContent;
      }
      static function getInvalidUserEmail(): stdClass
      {
        $faker = Factory::create();
        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userEmail = $faker->email();

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

      static function getValidNewUser()
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

      static function getInvalidNewUser()
      {
        $faker = Faker\Factory::create();

        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->firstName = $faker->firstName();
        $bodyContent->lastName = $faker->lastName();
        $bodyContent->userEmail = DEFAULT_USER_EMAIL;
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
        $bodyContent->userImageURL = DEFAULT_IMAGE_URL;

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

      public static function getValidAboutMe()
      {
        $faker = Faker\Factory::create();

        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = DEFAULT_USER_ID;
        $bodyContent->userAboutMe = $faker->words(5, true);

        $objContent->data = $bodyContent;

        return $objContent;
      }
      public static function getInvalidAboutMe()
      {
        $faker = Faker\Factory::create();

        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = $faker->uuid();
        $bodyContent->userAboutMe = $faker->words(5, true);

        $objContent->data = $bodyContent;

        return $objContent;
      }

      public static function getValidRemoveItemFromCartInput()
      {
        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = DEFAULT_USER_ID;
        $bodyContent->itemID = DEFAULT_ITEM_ID;

        $objContent->data = $bodyContent;

        return $objContent;
      }
      public static function getInvalidRemoveItemFromCartInput()
      {
        $faker = Factory::create();
        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = $faker->uuid();
        $bodyContent->itemID = DEFAULT_ITEM_ID;

        $objContent->data = $bodyContent;

        return $objContent;
      }

      public static function getValidUserID()
      {
        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = DEFAULT_USER_ID;

        $objContent->data = $bodyContent;

        return $objContent;
      }
      public static function getInvalidUserID()
      {
        $faker =  Factory::create();
        $objContent = new stdClass();

        $bodyContent = new stdClass();
        $bodyContent->userID = $faker->uuid();

        $objContent->data = $bodyContent;

        return $objContent;
      }
    }