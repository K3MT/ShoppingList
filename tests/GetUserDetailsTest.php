<?php

use \PHPUnit\Framework\TestCase;
use App\GetUserDetails;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetUserDetails
 * @covers App\GVM
 */
class GetUserDetailsTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getUserID();
    $objUserDetails = TestInput::getUserDetails();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objUserDetails->data;
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput::getUserID();

    $objRequest->data->userID = $faker->uuid(); // give a random uuid

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  /**
   * @test
   */
  public function testValidCall()
  {
    $expectedUserDetails = self::generateValidRequest();

    $response = GetUserDetails::makeCall();

    $arrResponse = (array) json_decode($response);

    $this->assertCount(1, $arrResponse, 'There is meant to be exactly one user object contained in the array');
    $objResponse = (object) $arrResponse[0];

    $this->assertEquals($expectedUserDetails->name, $objResponse->name);
    $this->assertEquals($expectedUserDetails->surname, $objResponse->surname);
    $this->assertEquals($expectedUserDetails->userImageURL, $objResponse->userImageURL);
    $this->assertEquals($expectedUserDetails->userAboutMe, $objResponse->userAboutMe);
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = GetUserDetails::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_USER\"/', $response, "Meant to receive an INVALID_USER response");
  }
}