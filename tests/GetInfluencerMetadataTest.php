<?php

use \PHPUnit\Framework\TestCase;
use App\GetInfluencerMetadata;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetInfluencerMetadata
 * @covers App\GVM
 */
class GetInfluencerMetadataTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getFollowerID();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput:: getFollowerID();

    $objRequest->data->followerID = $faker->uuid(); // give a random password

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  /**
   * @test
   */
  public function testValidCall()
  {
    self::generateValidRequest();

    $response = GetInfluencerMetadata::makeCall();

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

    $response = GetInfluencerMetadata::makeCall();


    $this->assertMatchesRegularExpression('/\"INVALID_FOLLOWER\"/', $response, "Meant to receive an INVALID_FOLLOWER response");
  }
}