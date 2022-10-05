<?php

use \PHPUnit\Framework\TestCase;
use App\GetAllItems;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetAllItems
 * @covers App\GVM */
class GetAllItemsTest extends \PHPUnit\Framework\TestCase
{
  /**
   * @test
   */
  public function testCall()
  {
    $_SERVER["REQUEST_METHOD"] = TestInput::$GET;

    $response = GetAllItems::makeCall();

    $objResponse = (array) json_decode($response);

    $this->assertGreaterThan(0, count($objResponse), 'There is meant to be more than one item');
    $this->assertMatchesRegularExpression('/\"itemID\"/', $response, 'Meant to contain item content');
  }
}