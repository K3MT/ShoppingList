<?php

use \PHPUnit\Framework\TestCase;
use App\GetFollowRequests;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetFollowRequests
 * @covers App\GVM
 */
class GetFollowRequestsTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getUserID();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput:: getUserID();

    $objRequest->data->userID = $faker->uuid(); // give a random password

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  /**
   * @test
   */
  public function testValidCall()
  {
    self::generateValidRequest();

    $response = GetFollowRequests::makeCall();

    $objResponse = (array) json_decode($response);

    $this->assertGreaterThan(-1, count($objResponse), 'There is meant to be an array of followers');

    if (count($objResponse) > 0)
      $this->assertMatchesRegularExpression('/\"userID\"/', $response, 'Meant to contain followers');
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = GetFollowRequests::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_USER\"/', $response, "Meant to receive an INVALID_USER response");
  }
}