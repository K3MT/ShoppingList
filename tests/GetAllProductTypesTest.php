<?php

// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\GetAllProductTypes;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\GetAllProductTypes
 * @covers \RequestObject
 * @covers APP\GVM
 */
class GetAllProductTypesTest extends TestCase
{
  public function testMakeCall()
  {
    $_SERVER["REQUEST_METHOD"] = "GET";

    $this->expectOutputRegex('/productName/');
    GetAllProductTypes::makeCall();
  }
}