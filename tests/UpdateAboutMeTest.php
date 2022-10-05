<?php

use App\GetUserDetails;
use \PHPUnit\Framework\TestCase;
use App\UpdateAboutMe;
use App\Registration;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\UpdateAboutMe
 * @covers \App\Registration
 * @covers App\GVM
 * @depends RegistrationTest::testValidCall
 * @depends RegistrationTest::testInvalidCall
 * @depends GetUserDetailsTest::testValidCall
 * @depends GetUserDetailsTest::testInvalidCall
 */
class UpdateAboutMeTest extends \PHPUnit\Framework\TestCase
{
  private static function writeNewAboutMe($objRequest, $userID)
  {
    $faker = Faker\Factory::create();

    $objRequest->data->userID = $userID;
    $objRequest->data->userAboutMe = $faker->words(10, true);

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objRequest->data->userAboutMe;
  }

  private static function writeUserDetailsRequest($userID)
  {
    $objRequest = TestInput::getUserID();

    $objRequest->data->userID = $userID; // Retrieve the new user ID of the newly registered user

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
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

    $objRequest->data->userID = $faker->uuid();
    $objRequest->data->aboutMe = $faker->words(5, true);

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

    self::writeUserDetailsRequest($newUUID);
    $response = GetUserDetails::makeCall();
    TestInput::log($response);
    $jsonResponse = (array) json_decode($response);
    $currUserDetails = $jsonResponse[0];

    $expectedAboutMe = self::writeNewAboutMe($objNewUserRequest, $newUUID);
    $response = UpdateAboutMe::makeCall();
    TestInput::log($response);
    $jsonResponse = (array) json_decode($response);
    $updateAboutMeResponse = $jsonResponse[0];

    $this->assertEquals($updateAboutMeResponse->name, $currUserDetails->name, "The first name associated with the new UUID is invalid");
    $this->assertEquals($updateAboutMeResponse->surname, $currUserDetails->surname, "The last name associated with the new UUID is invalid");
    $this->assertEquals($updateAboutMeResponse->userImageURL, $currUserDetails->userImageURL, "The image URL associated with the new UUID is invalid");
    $this->assertEquals($updateAboutMeResponse->userAboutMe, $expectedAboutMe, "The new about me is invalid");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = UpdateAboutMe::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_USER\"/', $response, "Meant to receive an INVALID_USER response");
  }
}