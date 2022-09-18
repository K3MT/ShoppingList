<?php
// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\GetSecurityQuestion;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\GetSecurityQuestion
 * @covers \RequestObject
 * @covers \GVM
 */
class GetSecurityQuestionTest extends TestCase {

  static function generateValidInput()
  {
    $objContent = TestInput::getValidUserEmail();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
  }
  static function generateInvalidInput()
  {
    $objContent = TestInput::getInvalidUserEmail();

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
    $this->expectOutputRegex('/securityQuestion/');
    GetSecurityQuestion::makeCall();
  }
  /**
   * @test
   */
  public function testMakeInvalidCall()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";

    self::generateInvalidInput();
    $this->expectOutputRegex('//');
    GetSecurityQuestion::makeCall();
  }

}