<?php
// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\ResetPassword;
require_once(__DIR__.'/../vendor/autoload.php');

require_once('inputHandler.php');

/**
 * @covers ResetPassword
 */
class ResetPasswordTest extends TestCase {

  /**
   *
   * Returns the new password to be checked
   */
  static function generateValidInput() : string
  {
    $objContent = TestInput::getResetPasswordInput();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);

    return $objContent->data->newPassword;
  }

  /**
   * @covers ResetPassword::makeCall
   */
  public function testMakeCall()
  {
    $newPassword = self::generateValidInput();

    $_SERVER["REQUEST_METHOD"] = "POST";

    $pattern = "/" . preg_quote($newPassword, "/") . "/";

    $this->expectOutputRegex($pattern, $newPassword);

    ResetPassword::makeCall();
  }

}