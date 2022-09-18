<?php
// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\PurchaseCart;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\PurchaseCart
 * @covers \RequestObject
 * @covers \GVM
 */
class PurchaseCartTest extends TestCase {

  static function generateValidInput()
  {
    $objContent = TestInput::getValidUserID();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
  }
  static function generateInvalidInput()
  {
    $objContent = TestInput::getInvalidUserID();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
  }

  /**
   * @test
   * @Depends AddItemToCartTest::testValidMakeCall()
   */
  public function testValidMakeCall()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";

    self::generateValidInput();
    $this->expectOutputRegex('//');
    PurchaseCart::makeCall();
  }
  /**
   * @test
   * @Depends AddItemToCartTest::testInvalidMakeCall()
   */
  public function testInvalidMakeCall()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";

    self::generateInvalidInput();
    $this->expectOutputRegex('/INVALID_USER/');
    PurchaseCart::makeCall();
  }

}