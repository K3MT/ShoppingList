<?php

use \PHPUnit\Framework\TestCase;
use App\Login;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\Login
 * @covers App\GVM
 */
class LoginTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getLoginDetails();
    $objUserDetails = TestInput::getUserID();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objUserDetails->data->userID;
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput:: getLoginDetails();

    $objRequest->data->userPassword = $faker->imei(); // give a random password

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  /**
   * @test
   */
  public function testValidCall()
  {
    $expectedUUID = self::generateValidRequest();

    $response = Login::makeCall();

    $this->assertMatchesRegularExpression('/\"userID\":\"'.$expectedUUID.'\"/', $response, "Meant to return the user's login details");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = Login::makeCall();


    $this->assertMatchesRegularExpression('/\"INVALID_LOGIN\"/', $response, "Meant to receive an INVALID_LOGIN response");
  }
}