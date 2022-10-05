<?php

use App\GetUserDetails;
use \PHPUnit\Framework\TestCase;
use App\Registration;
use App\ResetPassword;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\ResetPassword
 * @covers \App\Registration
 * @covers App\GVM
 * @depends RegistrationTest::testValidCall
 * @depends RegistrationTest::testInvalidCall
 */
class ResetPasswordTest extends \PHPUnit\Framework\TestCase
{
  private static function writeNewPassword($objRequest, $userID)
  {
    $faker = Faker\Factory::create();

    $objRequest->data->userID = $userID;
    $objRequest->data->newPassword = $faker->imei();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objRequest->data;
  }

  private static function generateValidRequest()
  {
    $objRequest = TestInput::getRegistrationDetails();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objRequest;
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();

    $objRequest = TestInput::getRegistrationDetails();

    $objRequest->data->userID = TestInput::$DEFAULT_USER_ID;
    $objRequest->data->newPassword = $faker->imei();
    $objRequest->data->securityAnswer = $faker->words(5, true);

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  /**
   * @test
   */
  public function testValidCall()
  {
    $faker = Faker\Factory::create();
    $objNewUserRequest = self::generateValidRequest();

    $response = Registration::makeCall();
    $jsonResponse = (array) json_decode($response);
    $newUUID = $jsonResponse[0]->userID;

    $updatedUser = self::writeNewPassword($objNewUserRequest, $newUUID);

    $response = ResetPassword::makeCall();
    $jsonResponse = (array) json_decode($response);
    $resetPasswordResponse = $jsonResponse[0];

    $this->assertEquals($resetPasswordResponse->userID, $updatedUser->userID, "The first name associated with the new UUID is invalid");
    $this->assertEquals($resetPasswordResponse->password, $updatedUser->newPassword, "The new password is invalid");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = ResetPassword::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_CREDENTIALS\"/', $response, "Meant to receive an INVALID_CREDENTIALS response");
  }
}