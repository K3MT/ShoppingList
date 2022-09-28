<?php
// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\ResetPassword;
require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\ResetPassword
 * @covers \RequestObject
 * @covers App\GVM
 */
class ResetPasswordTest extends TestCase {

  static function generateValidInput() : string
  {
    $objContent = TestInput::getValidResetPasswordInput();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);

    return $objContent->data->newPassword;
  }
  static function generateInvalidInput() : string
  {
    $objContent = TestInput::getInvalidResetPasswordInput();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);

    return $objContent->data->newPassword;
  }

  /**
   * @test
   */
  public function testMakeValidCall()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";

    self::generateValidInput();
    $this->expectOutputRegex('/userID/');
    ResetPassword::makeCall();
  }
  /**
   * @test
   */
  public function testMakeInvalidCall()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";

    self::generateInvalidInput();
    $this->expectOutputRegex('//');
    ResetPassword::makeCall();
  }

}