<?php
// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\ResetPassword;
require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\ResetPassword
 * @covers \RequestObject
 * @covers \GVM
 */
class ResetPasswordTest extends TestCase {

  static function generateValidInput() : string
  {
    $objContent = TestInput::getResetPasswordInput();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);

    return $objContent->data->newPassword;
  }

  public function testMakeCall()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";

    $newPassword = self::generateValidInput();

    $pattern = '/'.$newPassword.'/';

    $this->expectOutputRegex($pattern);

    ResetPassword::makeCall();
  }

}