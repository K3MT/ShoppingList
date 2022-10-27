<?php

use \PHPUnit\Framework\TestCase;
use App\GetSpecificItem;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetSpecificItem
 * @covers App\GVM */
class GetSpecificItemTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getItem();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objRequest->data->itemID;
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput::getItem();

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
    $expectedUUID = self::generateValidRequest();

    $response = GetSpecificItem::makeCall();

    $this->assertMatchesRegularExpression('/\"itemID\":\"'.$expectedUUID.'\"/', $response, "Meant to be successful in adding an item to list");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = GetSpecificItem::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_ENTRY\"/', $response, "Meant to receive an INVALID_ENTRY response");
  }
}