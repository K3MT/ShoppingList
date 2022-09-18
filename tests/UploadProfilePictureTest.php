<?php
// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\UploadProfilePicture;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\UploadProfilePicture
 * @covers \RequestObject
 * @covers \GVM
 */
class UploadProfilePictureTest extends TestCase {

  static function generateValidInput()
  {
    $objContent = TestInput::getValidDP();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
  }
  static function generateInvalidInput()
  {
    $objContent = TestInput::getInvalidDP();

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
    UploadProfilePicture::makeCall();
  }
  /**
   * @test
   */
  public function testMakeInvalidCall()
  {
    $_SERVER["REQUEST_METHOD"] = "POST";

    self::generateInvalidInput();
    $this->expectOutputRegex('//');
    UploadProfilePicture::makeCall();
  }

}