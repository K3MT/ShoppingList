<?php
// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\AddItemToCart;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\AddItemToCart
 * @uses \GVM
 */
class AddItemToCartTest extends TestCase {


  static function generateValidInput() : void
  {
    $objContent = TestInput::getExistingItemContent();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
  }
  static function generateInvalidInput() : void
  {
    $objContent = TestInput::getWrongItemContent();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
  }

  public function testMakeCall()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";

    self::generateValidInput();
    $this->expectOutputRegex('/itemName/');
    AddItemToCart::makeCall();

    self::generateInvalidInput();
    $this->expectOutputRegex('/INVALID_ENTRY/');
    AddItemToCart::makeCall();

  }

}