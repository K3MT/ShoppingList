<?php

use \PHPUnit\Framework\TestCase;
use App\RemoveItemFromTemplate;
use App\AddItemToTemplate;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\RemoveItemFromTemplate
 * @covers App\AddItemToTemplate
 * @covers App\GVM
 * @depends AddItemToTemplateTest::testValidCall
 * @depends AddItemToTemplateTest::testInvalidCall
 */
class RemoveItemFromTemplateTest extends \PHPUnit\Framework\TestCase
{
  private static function generateValidRequest()
  {
    $objRequest = TestInput::getItem();

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objRequest->data->itemID;
  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput::getItem();

    $objRequest->data->itemID = $faker->uuid(); // give a random uuid

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

    return $objRequest;
  }

  /**
   * @test
   */
  public function testValidCall()
  {
    $itemID = self::generateValidRequest();

    $maxAddedItems = rand(1, 5);
    $maxRemovedItems = rand(1, $maxAddedItems);

    // In order to remove anything, some items need to exist in the list beforehand
    for ($count = 0; $count < $maxAddedItems; $count++) {
      $response = AddItemToTemplate::makeCall();  // Already tested and is valid if reaching this test
    }

    // Retrieve the current quantity of items added to the Template
    $jsonResponse = (array) json_decode($response);
    $currQuantity = TestInput::getItemCount($jsonResponse, $itemID);


    for ($count = 0; $count < $maxRemovedItems; $count++) {
      $response = RemoveItemFromTemplate::makeCall();
    }

    $expectedRemainingQuantity = $currQuantity - $maxRemovedItems;

    // Retrieve the current quantity of items removed from the Template, within the response
    $jsonResponse = (array) json_decode($response);
    $currQuantity = TestInput::getItemCount($jsonResponse, $itemID);

    $this->assertEquals($expectedRemainingQuantity, $currQuantity, "The expected remaining items in the Template does not match the actual quantity");
  }
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = RemoveItemFromTemplate::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_ENTRY\"/', $response, "Meant to receive an INVALID_ENTRY response");
  }
}