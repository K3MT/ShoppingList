<?php

use App\GetFollowRequests;
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
 * @depends GetFollowRequestsTest::testValidCall
 * @depends GetFollowRequestsTest::testInvalidCall
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

    return $objRequest->data;
  }

  private static function generateGetFollowerRequests($influencerID)
  {
    $objRequest = TestInput::getUserID();

    $objRequest->data->userID = $influencerID;

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }


  private static function generateInvalidRequestID()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput:: getExistingRelationship();

    // Either non-existent users
    if (random_int(0, 1) == 0)
      $objRequest->data->influencerUserID = $faker->uuid();
    else if (random_int(0, 1) == 0)
      $objRequest->data->followerUserID = $faker->uuid();
    // Or following one's self
    else if (random_int(0, 1) == 0)
      $objRequest->data->influencerID = $objRequest->data->followerUserID;

    // If none of these if statements have been executed, the test for an already existing relationship is done

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
    $newRelationshipObj = self::generateNewRelationship($suggestedInfluencer);

    $response = SendFollowRequest::makeCall();
    $this->assertMatchesRegularExpression('/\"FOLLOW_REQUEST_SENT\"/', $response, 'Meant to be notified of the sent request');

    // Check that the user received the request
    self::generateGetFollowerRequests($newRelationshipObj->influencerUserID);
    $response = GetFollowRequests::makeCall();

    $this->assertMatchesRegularExpression('/\"userID\":\"'.$newRelationshipObj->followerUserID.'\"/', $response, 'Meant to contain the request of the new relationship');
  }
  /**
   * @test
   */
  public function testInvalidRequestID()
  {
    self::generateInvalidRequestID();

    $response = SendFollowRequest::makeCall();

    $this->assertMatchesRegularExpression('/INFLUENCER_ALREADY_ACCEPTED_REQUEST|INVALID_FOLLOWER_ID|INVALID_INFLUENCER_ID|INVALID_USER_ID_PAIR/', $response, "Meant to receive an INVALID_INFLUENCER_ID response");
  }
  /**
   * @test
   */
  public function testInvalidExistingRelationship()
  {
    self::generateExistingRelationship();

    $response = SendFollowRequest::makeCall();

    $this->assertMatchesRegularExpression('/INFLUENCER_ALREADY_ACCEPTED_REQUEST/', $response, "Meant to receive an INFLUENCER_ALREADY_ACCEPTED_REQUEST response");
  }
}