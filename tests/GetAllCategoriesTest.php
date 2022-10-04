<?php

use \PHPUnit\Framework\TestCase;
use App\GetAllCategories;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetAllCategories
 * @covers App\GVM */
class GetAllCategoriesTest extends \PHPUnit\Framework\TestCase
{
  /**
   * @test
   */
  public function testCall()
  {
    $_SERVER["REQUEST_METHOD"] = TestInput::$GET;

    $response = GetAllCategories::makeCall();

    $objResponse = (array) json_decode($response);

    $this->assertGreaterThan(0, count($objResponse), 'There is meant to be more than one category');
    $this->assertMatchesRegularExpression('/\"categoryName\"/', $response, "Meant to contain category names");
  }
}