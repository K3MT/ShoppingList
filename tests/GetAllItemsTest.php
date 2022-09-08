<?php
// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\GetAllItems;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetAllItems
 * @uses \GVM
 */
class GetAllItemsTest extends TestCase {


  static function generateValidInput() : void
  {
    $objContent = TestInput::getNewUser();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
  }

  public function testMakeCall()
  {
    $_SERVER["REQUEST_METHOD"] = "GET";

    $this->expectOutputRegex('/itemID/');
    GetAllItems::makeCall();
  }

}