<?php

use App\GetFollowRequests;
use App\GetInfluencerMetadata;
use App\GetUsersToFollow;
use App\SendFollowRequest;
use \PHPUnit\Framework\TestCase;
use App\RejectFollowRequest;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\RejectFollowRequest
 * @covers App\GVM
 * @depends GetUsersToFollowTest::testValidCall
 * @depends GetUsersToFollowTest::testInvalidCall
 * @depends GetFollowRequestsTest::testValidCall
 * @depends GetFollowRequestsTest::testInvalidCall
 * @depends SendFollowRequestTest::testValidCall
 * @depends GetInfluencerMetadataTest::testValidCall
 */
class RejectFollowRequestTest extends \PHPUnit\Framework\TestCase
{
  private static function generateGetInfluencerRequest($newRelationshipReq)
  {
    $newRelationshipReq->data->followerID = $newRelationshipReq->data->followerUserID;

    $jsonString = json_encode($newRelationshipReq);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

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

    return $objRequest;
  }

  private static function generateGetFollowerRequests($influencerID)
  {
    $objRequest = TestInput::getUserID();

    $objRequest->data->userID = $influencerID;

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objRequest;
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
    else
      $objRequest->data->influencerID = $objRequest->data->followerUserID;

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
    $newRelationshipReq = self::generateNewRelationship($suggestedInfluencer);
    $newRelationshipObj = $newRelationshipReq->data;
    SendFollowRequest::makeCall();

    // Reject the request
    $response = RejectFollowRequest::makeCall();
    $this->assertMatchesRegularExpression('/\"FOLLOW_REQUEST_REJECTED\"/', $response, 'Meant to be notified of the rejected request');

    // Check that the user no longer has the request
    self::generateGetFollowerRequests($newRelationshipObj->influencerUserID);
    $response = GetFollowRequests::makeCall();
    $this->assertDoesNotMatchRegularExpression('/\"userID\":\"'.$newRelationshipObj->followerUserID.'\"/', $response, 'The follow request should no longer appear here');

    // Check that the influencer is not followed by the user
    self::generateGetInfluencerRequest($newRelationshipReq);
    $response = GetInfluencerMetadata::makeCall();
    $this->assertDoesNotMatchRegularExpression('/\"userID\":\"'.$newRelationshipObj->influencerUserID.'\"/', $response, 'The new influencer is meant to be listed here');
  }

  /**
   * @test
   */
  public function testNonExistentRequest()
  {
    // First get the users one can follow
    self::generateFollowerSuggestionRequest();
    $jsonResponse = GetUsersToFollow::makeCall();
    $suggestionArr = (array) json_decode($jsonResponse);
    $randKey = array_rand($suggestionArr);
    $suggestedInfluencer = (object) $suggestionArr[$randKey];

    // Send the follow request to the user
    self::generateNewRelationship($suggestedInfluencer);
    $response = RejectFollowRequest::makeCall();

    $this->assertMatchesRegularExpression('/\"FOLLOW_REQUEST_DOESNT_EXIST\"/', $response, 'Meant to be FOLLOW_REQUEST_DOESNT_EXIST');
  }
  /**
   * @test
   */
  public function testAlreadyAcceptedRequest()
  {
    // First get the users one can follow
    self::generateExistingRelationship();

    // Send the follow request to the user
    $response = RejectFollowRequest::makeCall();

    $this->assertMatchesRegularExpression('/\"FOLLOW_REQUEST_ALREADY_ACCEPTED\"/', $response, 'Meant to be FOLLOW_REQUEST_ALREADY_ACCEPTED');
  }
  /**
   * @test
   */
  public function testInvalidRequestID()
  {
    self::generateInvalidRequestID();

    $response = RejectFollowRequest::makeCall();

    $this->assertMatchesRegularExpression('/FOLLOW_REQUEST_ALREADY_ACCEPTED|INVALID_FOLLOWER_ID|INVALID_INFLUENCER_ID|INVALID_USER_ID_PAIR/', $response, "Meant to receive an invalid response");
  }
}