<?php

use \PHPUnit\Framework\TestCase;
use App\AddItemToList;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\AddItemToList
 * @covers App\GVM */
class AddItemToListTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getItem();
    $objRequest->data->typeCart = "true";

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objRequest->data->itemID;
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput::getItem();

    $objRequest->data->typeCart = "true";
    $objRequest->data->itemID = $faker->uuid(); // give a random uuid

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objRequest->data->itemID;
  }

  /**
   * @test
   */
  public function testValidCall()
  {
    $addedItemID = self::generateValidRequest();

    $response = AddItemToList::makeCall();

    $this->assertMatchesRegularExpression('/\"itemID\":\"'.$addedItemID.'\"/', $response, "Meant to be successful in adding an item to list");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = AddItemToList::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_ENTRY\"/', $response, "Meant to receive an INVALID_ENTRY response");
  }
}