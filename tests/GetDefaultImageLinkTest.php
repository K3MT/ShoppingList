<?php

use \PHPUnit\Framework\TestCase;
use App\GetDefaultImageLink;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetDefaultImageLink
 * @covers App\GVM */
class GetDefaultImageLinkTest extends \PHPUnit\Framework\TestCase
{
  /**
   * @test
   */
  public function testCall()
  {
    $_SERVER["REQUEST_METHOD"] = TestInput::$GET;

    $response = GetDefaultImageLink::makeCall();

    $objResponse = (array) json_decode($response);

    $this->assertCount(1, $objResponse, 'There is meant to be exactly one default image link');
    $this->assertMatchesRegularExpression('/\"defaultUserImageURL\"/', $response, "Meant to contain the default user image URL");
  }
}