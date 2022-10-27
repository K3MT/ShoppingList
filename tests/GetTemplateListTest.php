<?php

use \PHPUnit\Framework\TestCase;
use App\GetTemplateList;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\GetTemplateList
 * @covers App\GVM */
class GetTemplateListTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getUserID();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput::getUserID();

    $objRequest->data->userID = $faker->uuid(); // give a random uuid

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  /**
   * @test
   */
  public function testValidCall()
  {
    self::generateValidRequest();

    $response = GetTemplateList::makeCall();

    $responseArr = (array) json_decode($response);

    $arrSize = count($responseArr);
    $this->assertGreaterThanOrEqual(0, $arrSize, "Meant to either have an item or be empty");

    if ($arrSize > 0)
      $this->assertMatchesRegularExpression('/\"itemID\"/', $response, "Elements are meant to be items");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = GetTemplateList::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_USER\"/', $response, "Meant to receive an INVALID_USER response");
  }
}