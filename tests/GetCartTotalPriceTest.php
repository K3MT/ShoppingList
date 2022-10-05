<?php

use \PHPUnit\Framework\TestCase;
use App\GetCartTotalPrice;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetCartTotalPrice
 * @covers App\GVM */
class GetCartTotalPriceTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getUserID();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput::getUserID();

    $objRequest->data->userID = $faker->uuid(); // give a random uuid

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  /**
   * @test
   */
  public function testValidCall()
  {
    self::generateValidRequest();

    $response = GetCartTotalPrice::makeCall();

    $this->assertMatchesRegularExpression('/\"totalCost\"|\[]/', $response, "Meant to have a total cost listed");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = GetCartTotalPrice::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_USER\"/', $response, "Meant to receive an INVALID_USER response");
  }
}