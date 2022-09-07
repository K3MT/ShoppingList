<?php
// use TestInput;
use \PHPUnit\Framework\TestCase;
use \App\GetAllItems;


require_once(__DIR__.'/../src/GVM.php');
require_once('inputHandler.php');

/**
 * @covers GetAllItems
 */
class GetAllItemsTest extends TestCase {

  /**
   * @covers GetAllItems::makeCall
   */
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