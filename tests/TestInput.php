<?php

require_once 'vendor/autoload.php';

use Faker\Factory;

class TestInput
{
  public static $POST = 'POST';
  public static $GET = 'GET';

  // User info
  public static $DEFAULT_USER_ID = 'd27dcd5c-3f5d-11ed-a0a3-062079ffe796';
  public static $DEFAULT_NAME = 'Myriam';
  public static $DEFAULT_SURNAME = 'Ortiz';
  public static $DEFAULT_PASSWORD = '#9499Qwertz';
  public static $DEFAULT_IMAGE_URL = 'http://lorempixel.com/640/480/transport';
  public static $DEFAULT_ABOUT_ME = 'I am a bot for testing the API of the system';
  public static $DEFAULT_EMAIL = '2326254@students.wits.ac.za';
  public static $DEFAULT_SECURITY_ANSWER = 'testing purposes';

  // List info
  public static $DEFAULT_LIST_ID = '56604c36-5562-11ed-a0a3-062079ffe796';
  public static $DEFAULT_LIST_NAME = 'veniam-est-eligendi';
  public static $DEFAULT_LIST_IMG_URL = 'https:\/\/i.imgur.com\/rN58RWC.png';

  // Follower info
  public static $DEFAULT_FOLLOWER_ID = 'd27dcd5c-3f5d-11ed-a0a3-062079ffe796';
  public static $DEFAULT_INFLUENCER_ID = 'b17b7c6e-4023-11ed-a0a3-062079ffe796';

  // Item info
  public static $DEFAULT_ITEM_ID = '52315eed-282f-11ed-a567-e454e831c10d';
  public static $ITEM_IDS = ['522fa3f4-282f-11ed-a567-e454e831c10d',
    '52306e1a-282f-11ed-a567-e454e831c10d',
    '52315eed-282f-11ed-a567-e454e831c10d',
    '5232427d-282f-11ed-a567-e454e831c10d',
    '5233133a-282f-11ed-a567-e454e831c10d',
    '5233dba8-282f-11ed-a567-e454e831c10d',
    '52349e3e-282f-11ed-a567-e454e831c10d',
    '52358877-282f-11ed-a567-e454e831c10d',
    '52368256-282f-11ed-a567-e454e831c10d',
    '52374adf-282f-11ed-a567-e454e831c10d',
    '5237f188-282f-11ed-a567-e454e831c10d',
  ];

  static function log($message) {
    fwrite(STDERR, "\n\nLOGGER:::\n".$message."\n\n");
  }

  /**
   * Prepares a mock HTML request in a file for testing
   * @param $fName
   * @param $strContent
   * @return void
   */
  static function writeInput($requestType, $fName, $strContent) {
    $_SERVER["REQUEST_METHOD"] = $requestType;

    $fileWriter = fopen($fName, "w");

    fwrite($fileWriter, $strContent);

    fclose($fileWriter);
  }

  public static function getItem()
  {
    $faker = Faker\Factory::create();
    $dex = array_rand(self::$ITEM_IDS);

    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->userID = self::$DEFAULT_USER_ID;
    $bodyContent->itemID = self::$ITEM_IDS[$dex];

    $objContent->data = $bodyContent;

    return $objContent;
  }


  public static function getListItem()
  {
    $faker = Faker\Factory::create();
    $dex = array_rand(self::$ITEM_IDS);

    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->listID = self::$DEFAULT_LIST_ID;
    $bodyContent->itemID = self::$ITEM_IDS[$dex];

    $objContent->data = $bodyContent;

    return $objContent;
  }

  public static function getUserID()
  {
    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->userID = self::$DEFAULT_USER_ID;

    $objContent->data = $bodyContent;

    return $objContent;
  }

  public static function getUserEmail()
  {
    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->userID = self::$DEFAULT_USER_ID;
    $bodyContent->userEmail = self::$DEFAULT_EMAIL;

    $objContent->data = $bodyContent;

    return $objContent;
  }

  public static function getUserDetails()
  {
    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->name = self::$DEFAULT_NAME;
    $bodyContent->surname = self::$DEFAULT_SURNAME;
    $bodyContent->userImageURL = self::$DEFAULT_IMAGE_URL;
    $bodyContent->userAboutMe = self::$DEFAULT_ABOUT_ME;

    $objContent->data = $bodyContent;

    return $objContent;
  }

  public static function getLoginDetails()
  {
    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->userEmail = self::$DEFAULT_EMAIL;
    $bodyContent->userPassword = self::$DEFAULT_PASSWORD;

    $objContent->data = $bodyContent;

    return $objContent;
  }

  /**
   * Returns the quantity of items given the itemID within a response list
   * @param array $response
   * @param $itemID
   * @return int
   */
  public static function getItemCount(array $response, string $itemID)
  {
    $itemDex = 0;

    while ($itemDex < count($response)) {
      $currItemID = (string) $response[$itemDex]->itemID;
      if ($currItemID == $itemID) {
        break;
      }
      ++$itemDex;
    }

    // If the itemID is not found there is no more of that item
    if ($itemDex == count($response)) {
      return 0;
    }

    return $response[$itemDex]->count;
  }

  public static function getRegistrationDetails()
  {
    $faker = Faker\Factory::create();

    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->firstName = $faker->firstName();
    $bodyContent->lastName = $faker->lastName();
    $bodyContent->userEmail = $faker->email();
    $bodyContent->userPassword = $faker->imei();
    $bodyContent->securityQuestion = $faker->words(5, true);
    $bodyContent->securityAnswer = $faker->words(5, true);

    $bodyContent->userAboutMe = 'I am '.$bodyContent->firstName.' and I am using K3MT Shopping List';


    $objContent->data = $bodyContent;

    return $objContent;
  }

  public static function getRequestObject()
  {
    $faker = Faker\Factory::create();

    $requestObject = new stdClass();
    $requestObject->key = $faker->word();
    $requestObject->value = $faker->word();

    return $requestObject;
  }

  public static function getExitingList()
  {
    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->listID = self::$DEFAULT_LIST_ID;
    $bodyContent->listName = self::$DEFAULT_LIST_NAME;
    $bodyContent->listImageURL = self::$DEFAULT_LIST_IMG_URL;

    $objContent->data = $bodyContent;

    return $objContent;
  }

  public static function getnewList()
  {
    $faker = Faker\Factory::create();

    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->userID = self::$DEFAULT_USER_ID;
    $bodyContent->listName = $faker->slug(3, false);

    $objContent->data = $bodyContent;

    return $objContent;
  }

  public static function getUserList()
  {
    $faker = Faker\Factory::create();

    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->userID = self::$DEFAULT_USER_ID;
    $bodyContent->listID = self::$DEFAULT_LIST_ID;

    $objContent->data = $bodyContent;

    return $objContent;
  }

  public static function getUserFollower()
  {
    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->followerID = self::$DEFAULT_USER_ID;

    $objContent->data = $bodyContent;

    return $objContent;
  }

  public static function getInfluenceerID()
  {
    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->influencerID = self::$DEFAULT_USER_ID;

    $objContent->data = $bodyContent;

    return $objContent;
  }

  public static function getExistingRelationship()
  {
    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->followerUserID = self::$DEFAULT_FOLLOWER_ID;
    $bodyContent->influencerUserID = self::$DEFAULT_INFLUENCER_ID;

    $objContent->data = $bodyContent;

    return $objContent;
  }

  public static function getNewRelationship($influencerID)
  {
    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->followerUserID = self::$DEFAULT_FOLLOWER_ID;
    $bodyContent->influencerUserID = $influencerID;

    $objContent->data = $bodyContent;

    return $objContent;
  }

  public static function getFollowerID()
  {
    $objContent = new stdClass();

    $bodyContent = new stdClass();
    $bodyContent->followerID = self::$DEFAULT_FOLLOWER_ID;

    $objContent->data = $bodyContent;

    return $objContent;
  }


}