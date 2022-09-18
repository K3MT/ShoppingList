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

  public function testMakeCall()
  {
    $_SERVER["REQUEST_METHOD"] = "GET";

    $this->expectOutputRegex('/itemID/');
    GetAllItems::makeCall();
  }

}