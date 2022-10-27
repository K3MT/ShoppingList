<?php

use App\GetTemplateList;
use \PHPUnit\Framework\TestCase;
use App\AddItemToTemplate;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\AddItemToTemplate
 * @covers \App\GetTemplateList
 * @covers App\GVM
 * @depends GetTemplateListTest::testValidCall
 * @depends GetTemplateListTest::testInvalidCall
 */
class AddItemToTemplateTest extends \PHPUnit\Framework\TestCase
{
  private static function writeRequest($objRequest)
  {
    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput::getItem();

    $objRequest->data->userID = $faker->uuid(); // give a random uuid

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objRequest->data->itemID;
  }

  private static function generateValidTemplateRequest()
  {
    $objRequest = TestInput::getItem();

    self::writeRequest($objRequest);
    return $objRequest->data->itemID;
  }

   /**
    * @test
    */
   public function testValidCall()
   {
     $addedItemID = self::generateValidTemplateRequest();

     $response = GetTemplateList::makeCall();  // Need to check if the item to be added exists in the Template

     // Retrieve the current quantity of items added to the Template
     $jsonResponse = (array) json_decode($response);

     $currQuantity = TestInput::getItemCount($jsonResponse, $addedItemID);
     $expectedQuantity = $currQuantity + 1;

     $response = AddItemToTemplate::makeCall();

     // Retrieve the current quantity of items added to the Template
     $jsonResponse = (array) json_decode($response);
     $responseQuantity = TestInput::getItemCount($jsonResponse, $addedItemID);

     $this->assertMatchesRegularExpression('/\"itemID\":\"'.$addedItemID.'\"/', $response, "Meant to be successful in adding an item to Template");
     $this->assertEquals($expectedQuantity, $responseQuantity, "The quantity of the item added should have increased by 1");
   }
   /**
    * @test
    */
   public function testInvalidCall()
   {
     self::generateInvalidRequest();

     $response = AddItemToTemplate::makeCall();

     $this->assertMatchesRegularExpression('/\"INVALID_ENTRY\"/', $response, "Meant to receive an INVALID_ENTRY response");
   }
}