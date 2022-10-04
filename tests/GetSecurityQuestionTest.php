<?php

use \PHPUnit\Framework\TestCase;
use App\GetSecurityQuestion;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetSecurityQuestion
 * @covers App\GVM */
class GetSecurityQuestionTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getUserEmail();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objRequest->data->userID;
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput::getUserEmail();

    $objRequest->data->userEmail = $faker->email(); // give a random email

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

  /**
   * @test
   */
  public function testValidCall()
  {
    $expectedUUID = self::generateValidRequest();

    $response = GetSecurityQuestion::makeCall();

    $this->assertMatchesRegularExpression('/\"userID\":\"'.$expectedUUID.'\"/', $response, "Meant to have the security question of the given user");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = GetSecurityQuestion::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_USER_EMAIL\"/', $response, "Meant to receive an INVALID_USER_EMAIL response");
  }
}