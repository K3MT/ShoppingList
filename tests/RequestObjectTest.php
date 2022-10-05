<?php

use \PHPUnit\Framework\TestCase;
use App\RequestObject;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\RequestObject
 * @covers App\GVM
 */
class RequestObjectTest extends \PHPUnit\Framework\TestCase
{
  /**
   * @test
   */
  public function testRequestObject()
  {
    $inputObject = TestInput::getRequestObject();

    $requestObject = new RequestObject($inputObject->key, $inputObject->value);

    $jsonObject = json_encode($requestObject);

    TestInput::log($jsonObject);

    $this->assertMatchesRegularExpression('/{\"content\":\"'.$inputObject->key.'\",\"quotify\":\"'.$inputObject->value.'\"}/', $jsonObject, "Meant to match the json Object");
  }
}