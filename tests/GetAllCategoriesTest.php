<?php
// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\GetAllCategories;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetAllCategories
 * @uses \GVM
 */
class GetAllCategoriesTest extends TestCase {

  static function generateValidInput()
  {
    $objContent = TestInput::getExistingItemContent();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
  }

  /**
   * @test
   */
  public function testValidMakeCall()
  {
    $_SERVER["REQUEST_METHOD"] = "GET";

    self::generateValidInput();
    $this->expectOutputRegex('/categoryName/');
    GetAllCategories::makeCall();
  }

}