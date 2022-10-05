<?php

use \PHPUnit\Framework\TestCase;
use App\GetAllProductTypes;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetAllProductTypes
 * @covers App\GVM */
class GetAllProductTypesTest extends \PHPUnit\Framework\TestCase
{
  /**
   * @test
   */
  public function testCall()
  {
    $_SERVER["REQUEST_METHOD"] = TestInput::$GET;

    $response = GetAllProductTypes::makeCall();

    $objResponse = (array) json_decode($response);

    $this->assertGreaterThan(0, count($objResponse), 'There is meant to be more than one product type');
    $this->assertMatchesRegularExpression('/\"productName\"/', $response, 'Meant to contain product types');
  }
}