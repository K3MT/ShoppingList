<?php
// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\RemoveItemFromCart;
use App\AddItemToCart;
require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\RemoveItemFromCart
 * @covers App\AddItemToCart
 * @covers \RequestObject
 * @covers \GVM
 */
class RemoveItemFromCartTest extends TestCase {

  static function generateValidInput()
  {
    $objContent = TestInput::getValidRemoveItemFromCartInput();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
  }
  static function generateInvalidInput()
  {
    $objContent = TestInput::getInvalidRemoveItemFromCartInput();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
  }

  /**
   * @test
   * @Depends AddItemToCartTest::testValidMakeCall()
   * @Depends PurchaseCartTest::testValidMakeCall()
   */
  public function testMakeValidCall()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";

    self::generateValidInput();
    $this->expectOutputRegex("/(itemName)*/");
    RemoveItemFromCart::makeCall();
  }
  /**
   * @test
   * @Depends AddItemToCartTest::testMakeCall()
   */
  public function MakeInvalidCall()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";

    self::generateInvalidInput();
    $this->expectOutputRegex('/INVALID_ENTRY/');
    RemoveItemFromCart::makeCall();
  }

}