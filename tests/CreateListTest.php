<?php

use \PHPUnit\Framework\TestCase;
use App\CreateList;
use App\GetListMetadata;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\CreateList
 * @covers \App\GetActiveCart
 * @covers App\GVM
 * @covers App\GetListMetadata
 * @depends GetListMetadataTest::testValidCall
 * @depends GetListMetadataTest::testInvalidCall
 */
class CreateListTest extends \PHPUnit\Framework\TestCase
{
  private static function writeRequest($objRequest)
  {
    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput::getNewList();
    $objRequest->data->userID = $faker->uuid();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

  private static function generateValidRequest()
  {
    $objRequest = TestInput::getnewList();

    self::writeRequest($objRequest);
    return $objRequest;
  }

  private static function writeListRetrievalRequest($req, $newID)
  {
    $req->data->listID = $newID;

    self::writeRequest($req);
  }

  /**
   * @test
   */
  public function testValidCall()
  {
    $requestObject = self::generateValidRequest();

    $response = CreateList::makeCall();

    // Retrieve the new ID and test whether it exists
    // And contains the correct content

    $jsonResponse = (array) json_decode($response);
    $responseListID = ((object) $jsonResponse[0])->listID;

    self::writeListRetrievalRequest($requestObject, $responseListID);

    $response = GetListMetadata::makeCall();
    $jsonResponse = (array) json_decode($response);
    $responseObj = (object) $jsonResponse[0];

    $expectedResponseObj = $requestObject->data;

    $this->assertEquals($expectedResponseObj->listID, $responseObj->listID);
    $this->assertEquals($expectedResponseObj->listName, $responseObj->listName);
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = CreateList::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_USER\"/', $response, "Meant to receive an INVALID_USER response");
  }
}