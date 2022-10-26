<?php

use \PHPUnit\Framework\TestCase;
use App\CreateList;
use App\DeleteList;
use App\GetListMetadata;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\DeleteList
 * @covers \App\CreateList
 * @covers \App\GetActiveCart
 * @covers App\GVM
 * @covers App\GetListMetadata
 * @depends CreateListTest::testValidCall
 * @depends CreateListTest::testInvalidCall
 * @depends GetListMetadataTest::testValidCall
 * @depends GetListMetadataTest::testInvalidCall
 */
class DeleteListTest extends \PHPUnit\Framework\TestCase
{
  private static function writeRequest($objRequest)
  {
    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput::getExitingList();
    $objRequest->data->listID = $faker->uuid();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

  private static function generateValidRequest()
  {
    $objRequest = TestInput::getnewList();

    self::writeRequest($objRequest);
    return $objRequest;
  }

  private static function writeListCreationRequest()
  {
    $objRequest = TestInput::getnewList();

    self::writeRequest($objRequest);
    return $objRequest;
  }

  private static function writeListRemovalnRequest($req, $newID)
  {
    $req->data->listID = $newID;

    self::writeRequest($req);
  }


  /**
   * @test
   */
  public function testValidCall()
  {
    // Create a temporary list to be deleted
    $requestObject = self::writeListCreationRequest();

    $response = CreateList::makeCall();
    $jsonResponse = (array) json_decode($response);
    $newListID = ((object) $jsonResponse[0])->listID;

    // Test list deletion
    self::writeListRemovalnRequest($requestObject, $newListID);
    $response = DeleteList::makeCall();

    // Check if the list no longer exists, this should be the case
    $response = GetListMetadata::makeCall();
    $this->assertMatchesRegularExpression('/\"INVALID_LIST\"/', $response, "Meant to receive an INVALID_LIST response");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = DeleteList::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_LIST\"/', $response, "Meant to receive an INVALID_LIST response");
  }
}