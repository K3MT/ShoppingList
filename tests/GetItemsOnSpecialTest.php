<?php

use \PHPUnit\Framework\TestCase;
use App\GetItemsOnSpecial;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetItemsOnSpecial
 * @covers App\GVM */
class GetItemsOnSpecialTest extends \PHPUnit\Framework\TestCase
{
  /**
   * @test
   */
  public function testCall()
  {
    $_SERVER["REQUEST_METHOD"] = TestInput::$GET;

    $response = GetItemsOnSpecial::makeCall();

    $objResponse = (array) json_decode($response);

    $this->assertGreaterThan(0, $objResponse, 'There is meant to be at least one item special');
    $this->assertMatchesRegularExpression('/\"itemID\"/', $response, "Meant to contain the details of an item");
  }
}