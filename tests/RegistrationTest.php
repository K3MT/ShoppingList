<?php

use App\GetUserDetails;
use \PHPUnit\Framework\TestCase;
use App\Registration;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\Registration
 * @covers App\GVM
 * @depends GetUserDetailsTest::testValidCall
 * @depends GetUserDetailsTest::testInvalidCall
 */
class RegistrationTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getRegistrationDetails();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objRequest->data;
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput:: getRegistrationDetails();

    $objRequest->data->userEmail = TestInput::$DEFAULT_EMAIL;

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  private static function writeUserDetailsRequest($userID)
  {
    $objRequest = TestInput::getUserID();

    $objRequest->data->userID = $userID; // Retrieve the new user ID of the newly registered user

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

  /**
   * @test
   */
  public function testValidCall()
  {
    $newUserDetails = self::generateValidRequest();

    $response = Registration::makeCall();
    $jsonResponse = (array) json_decode($response);
    $newUserID = $jsonResponse[0]->userID;

    self::writeUserDetailsRequest($newUserID);

    $response = GetUserDetails::makeCall();

    $jsonResponse = (array) json_decode($response);
    $objRegisteredUser = $jsonResponse[0];

    $this->assertEquals($newUserDetails->firstName, $objRegisteredUser->name, "The first name associated with the new UUID is invalid");
    $this->assertEquals($newUserDetails->lastName, $objRegisteredUser->surname, "The last name associated with the new UUID is invalid");
    $this->assertEquals($newUserDetails->userAboutMe, $objRegisteredUser->userAboutMe, "The user's about me associated with the new UUID is invalid");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = Registration::makeCall();

    $this->assertMatchesRegularExpression('/\"DUPLICATE_USER_EMAIL\"/', $response, "Meant to receive a DUPLICATE_USER_EMAIL response");
  }
}