<?php

use App\GetUsersToFollow;
use \PHPUnit\Framework\TestCase;
use App\SendFollowRequest;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\SendFollowRequest
 * @covers App\GVM
 * @depends GetUsersToFollowTest::testValidCall
 * @depends GetUsersToFollowTest::testInvalidCall
 */
class SendFollowRequestTest extends \PHPUnit\Framework\TestCase
{
  private static function generateFollowerSuggestionRequest()
  {
    $objRequest = TestInput::getUserFollower();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

  private static function generateExistingRelationship()
  {
    $objRequest = TestInput::getExistingRelationship();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

  private static function generateNewRelationship($newInfluencerObj)
  {
    $objRequest = TestInput::getNewRelationship($newInfluencerObj->userID);

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }


  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput:: getExistingRelationship();

    // Either non-existent users
    if (random_int(0, 1) == 0)
      $objRequest->data->influencerUserID = $faker->uuid(); // give a random password
    else if (random_int(0, 1) == 0)
      $objRequest->data->followerUserID = $faker->uuid(); // give a random password
    // Or following one's self
    else if (random_int(0, 1) == 0)
      $objRequest->data->influencerID = $objRequest->data->followerUserID; // give a random password




    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  /**
   * @test
   */
  public function testValidCall()
  {
    // First get the users one can follow
    self::generateFollowerSuggestionRequest();

    $jsonResponse = GetUsersToFollow::makeCall();
    $suggestionArr = (array) json_decode($jsonResponse);
    $randKey = array_rand($suggestionArr);
    $suggestedInfluencer = (object) $suggestionArr[$randKey];

    // Send the follow request to the user
    self::generateNewRelationship($suggestedInfluencer);

    $response = SendFollowRequest::makeCall();

    // Check if the influencer received the follow request
    $objResponse = (array) json_decode($response);

    $this->assertGreaterThan(-1, count($objResponse), 'There is meant to be an array of followers');

    if (count($objResponse) > 0)
      $this->assertMatchesRegularExpression('/\"FOLLOW_REQUEST_SENT\"/', $response, 'Meant to be notified of the sent request');
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = SendFollowRequest::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_INFLUENCER_ID\"|FOLLOW_REQUEST_ALREADY_SENT|INFLUENCER_ALREADY_ACCEPTED_REQUEST|INVALID_USER_ID_PAIR/', $response, "Meant to receive an INVALID_INFLUENCER_ID response");
  }
}