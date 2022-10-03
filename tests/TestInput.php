<?php

require_once 'vendor/autoload.php';

use Faker\Factory;

class TestInput
{
  public static $POST = 'POST';
  public static $GET = 'GET';
  public static $DEFAULT_USER_ID = 'd27dcd5c-3f5d-11ed-a0a3-062079ffe796';
  public static $DEFAULT_PASSWORD = '#9499Qwertz';
  public static $DEFAULT_IMAGE_URL = 'http://lorempixel.com/640/480/transport';
  public static $DEFAULT_EMAIL = '2326254@students.wits.ac.za';
  public static $DEFAULT_SECURITY_ANSWER = 'testing purposes';
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
    fwrite(STDERR, $message."\n\n");
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
    $bodyContent->typeTemplate = "false";
    $bodyContent->typeCart = "false";
    $bodyContent->typePublic = "false";

    $objContent->data = $bodyContent;

    return $objContent;
  }


}