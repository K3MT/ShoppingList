<?php
// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\GetActiveCart;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\GetActiveCart
 * @covers \RequestObject
 * @covers \GVM
 */
class GetActiveCartTest extends TestCase {

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
   */
  public function testMakeValidCall()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";

    self::generateValidInput();
    $this->expectOutputRegex("/(itemName)*/");
    GetActiveCart::makeCall();
  }
  /**
   * @test
   */
  public function testMakeInvalidCall()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";

    self::generateInvalidInput();
    $this->expectOutputRegex('/INVALID_USER/');
    GetActiveCart::makeCall();
  }

}