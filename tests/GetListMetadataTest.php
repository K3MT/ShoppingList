<?php

use \PHPUnit\Framework\TestCase;
use App\GetListMetadata;
use App\GetActiveCart;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetListMetadata
 * @covers \App\GetActiveCart
 * @covers App\GVM
 */
class GetListMetadataTest extends \PHPUnit\Framework\TestCase
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
    $objRequest = TestInput::getExitingList();

    self::writeRequest($objRequest);
    return $objRequest->data;
  }

  /**
   * @test
   */
  public function testValidCall()
  {
    $expectedResponseObj = self::generateValidRequest();

    $response = GetListMetadata::makeCall();

    // Retrieve the current quantity of items added to the cart
    $jsonResponse = (array) json_decode($response);
    $responseObj = (object) $jsonResponse[0];

    $this->assertEquals($expectedResponseObj->listID, $responseObj->listID);
    $this->assertEquals($expectedResponseObj->listName, $responseObj->listName);
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = GetListMetadata::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_LIST\"/', $response, "Meant to receive an INVALID_LIST response");
  }
}