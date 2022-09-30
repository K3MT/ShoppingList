<?php
// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\UpdateAboutMe;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\UpdateAboutMe
 * @covers \RequestObject
 * @covers App\GVM
 */
class UpdateAboutMeTest extends TestCase {

  static function generateValidInput()
  {
    $objContent = TestInput::getValidAboutMe();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
  }
  static function generateInvalidInput()
  {
    $objContent = TestInput::getInvalidAboutMe();

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
    $this->expectOutputRegex('/name/');
    UpdateAboutMe::makeCall();
  }
  /**
   * @test
   */
  public function testMakeInvalidCall()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";

    self::generateInvalidInput();
    $this->expectOutputRegex('//');
    UpdateAboutMe::makeCall();
  }

}