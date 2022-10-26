<?php

use \PHPUnit\Framework\TestCase;
use App\GetListItems;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetListItems
 * @covers App\GVM */
class GetListItemsTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getExitingList();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput::getExitingList();

    $objRequest->data->listID = $faker->uuid(); // give a random uuid

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  /**
   * @test
   */
  public function testValidCall()
  {
    self::generateValidRequest();

    $response = GetListItems::makeCall();

    $responseArr = (array) json_decode($response);

    $arrSize = count($responseArr);
    $this->assertGreaterThanOrEqual(0, $arrSize, "Meant to either have an item or be empty");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = GetListItems::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_LIST\"/', $response, "Meant to receive an INVALID_LIST response");
  }
}