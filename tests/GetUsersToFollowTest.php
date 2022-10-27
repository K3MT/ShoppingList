<?php

use \PHPUnit\Framework\TestCase;
use App\GetUsersToFollow;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetUsersToFollow
 * @covers App\GVM
 */
class GetUsersToFollowTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getUserFollower();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput:: getUserFollower();

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

    $response = GetUsersToFollow::makeCall();

    $objResponse = (array) json_decode($response);

    $this->assertGreaterThan(0, count($objResponse), 'There is meant to be more than one influencer');
    $this->assertMatchesRegularExpression('/\"userID\"/', $response, 'Meant to contain influencers');
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = GetUsersToFollow::makeCall();


    $this->assertMatchesRegularExpression('/\"INVALID_FOLLOWER\"/', $response, "Meant to receive an INVALID_FOLLOWER response");
  }
}