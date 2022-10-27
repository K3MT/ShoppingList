<?php

use \PHPUnit\Framework\TestCase;
use App\GetFollowerMetadata;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetFollowerMetadata
 * @covers App\GVM
 */
class GetFollowerMetadataTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getInfluenceerID();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput:: getUserID();

    $objRequest->data->influencerID = $faker->uuid(); // give a random password

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  /**
   * @test
   */
  public function testValidCall()
  {
    self::generateValidRequest();

    $response = GetFollowerMetadata::makeCall();

    $objResponse = (array) json_decode($response);

    $this->assertGreaterThan(-1, count($objResponse), 'There is meant to be an array of influencers');

    if (count($objResponse) > 0)
      $this->assertMatchesRegularExpression('/\"userID\"/', $response, 'Meant to contain influencers');
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = GetFollowerMetadata::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_INFLUENCER\"/', $response, "Meant to receive an INVALID_INFLUENCER response");
  }
}