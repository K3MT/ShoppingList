<?php

use \PHPUnit\Framework\TestCase;
use App\GetAllUserFullNames;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetAllUserFullNames
 * @covers App\GVM */
class GetAllUserFullNamesTest extends \PHPUnit\Framework\TestCase
{
  /**
   * @test
   */
  public function testCall()
  {
    $_SERVER["REQUEST_METHOD"] = TestInput::$GET;

    $response = GetAllUserFullNames::makeCall();

    $objResponse = (array) json_decode($response);

    $this->assertGreaterThan(0, count($objResponse), 'There is meant to be more than one product type');
    $this->assertMatchesRegularExpression('/\"name\"/', $response, 'Meant to contain product types');
  }
}