<?php

use \PHPUnit\Framework\TestCase;
use App\GetPopularItems;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetPopularItems
 * @covers App\GVM */
class GetPopularItemsTest extends \PHPUnit\Framework\TestCase
{
  /**
   * @test
   */
  public function testCall()
  {
    $_SERVER["REQUEST_METHOD"] = TestInput::$GET;

    $response = GetPopularItems::makeCall();

    $objResponse = (array) json_decode($response);

    $this->assertGreaterThan(0, $objResponse, 'There is meant to be at least one popular item');
    $this->assertMatchesRegularExpression('/\"itemID\"/', $response, "Meant to contain the details of a popular item");
  }
}