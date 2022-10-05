<?php

use \PHPUnit\Framework\TestCase;
use App\PurchaseCart;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\PurchaseCart
 * @covers App\GVM
 */
class PurchaseCartTest extends \PHPUnit\Framework\TestCase
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

    $response = PurchaseCart::makeCall();

    $this->assertMatchesRegularExpression('/\"itemName\"|\[]/', $response, "Meant to either have an item or be empty");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = PurchaseCart::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_USER\"/', $response, "Meant to receive an INVALID_USER response");
  }
}