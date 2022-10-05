<?php

use App\GetUserDetails;
use PHPUnit\Framework\TestCase;
use App\UploadProfilePicture;
use App\Registration;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\UploadProfilePicture
 * @covers \App\Registration
 * @covers App\GVM
 * @depends RegistrationTest::testValidCall
 * @depends RegistrationTest::testInvalidCall
 * @depends GetUserDetailsTest::testValidCall
 * @depends GetUserDetailsTest::testInvalidCall
 */
class UploadProfilePictureTest extends \PHPUnit\Framework\TestCase
{
  private static function writeNewProfilePicture($objRequest, $userID)
  {
    $BASE_URL = 'http://lorempixel.com/640/480/';
    $faker = Faker\Factory::create();

    $objRequest->data->userID = $userID;
    $objRequest->data->userImageURL = $BASE_URL.$faker->word();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objRequest->data->userImageURL;
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
    $objRequest->data->userImageURL = $faker->imageUrl();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  /**
   * @test
   */
  public function testValidCall()
  {
    $objNewUserRequest = self::generateValidRequest();

    $response = Registration::makeCall();
    $jsonResponse = (array) json_decode($response);
    $newUUID = $jsonResponse[0]->userID;

    self::writeUserDetailsRequest($newUUID);
    $response = GetUserDetails::makeCall();
    TestInput::log($response);
    $jsonResponse = (array) json_decode($response);
    $currUserDetails = $jsonResponse[0];

    $expectedImageURL = self::writeNewProfilePicture($objNewUserRequest, $newUUID);
    $response = UploadProfilePicture::makeCall();
    TestInput::log($response);
    $jsonResponse = (array) json_decode($response);
    $UploadProfilePictureResponse = $jsonResponse[0];

    $this->assertEquals($UploadProfilePictureResponse->name, $currUserDetails->name, "The first name associated with the new UUID is invalid");
    $this->assertEquals($UploadProfilePictureResponse->surname, $currUserDetails->surname, "The last name associated with the new UUID is invalid");
    $this->assertEquals($UploadProfilePictureResponse->userAboutMe, $currUserDetails->userAboutMe, "The last name associated with the new UUID isuser's about me is invalid");
    $this->assertEquals($UploadProfilePictureResponse->userImageURL, $expectedImageURL, "The new image URL associated with the new UUID is invalid");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = UploadProfilePicture::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_USER\"/', $response, "Meant to receive an INVALID_USER response");
  }
}