<?php

use \PHPUnit\Framework\TestCase;
use App\RemoveItemFromCart;
use App\AddItemToCart;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\RemoveItemFromCart
 * @covers App\AddItemToCart
 * @covers App\GVM
 * @depends AddItemToCartTest::testValidCall
 * @depends AddItemToCartTest::testInvalidCall
 */
class RemoveItemFromCartTest extends \PHPUnit\Framework\TestCase
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
      $response = AddItemToCart::makeCall();  // Already tested and is valid if reaching this test
    }

    // Retrieve the current quantity of items added to the cart
    $jsonResponse = (array) json_decode($response);
    $currQuantity = TestInput::getItemCount($jsonResponse, $itemID);


    for ($count = 0; $count < $maxRemovedItems; $count++) {
      $response = RemoveItemFromCart::makeCall();
    }

    $expectedRemainingQuantity = $currQuantity - $maxRemovedItems;

    // Retrieve the current quantity of items removed from the cart, within the response
    $jsonResponse = (array) json_decode($response);
    $currQuantity = TestInput::getItemCount($jsonResponse, $itemID);

    $this->assertEquals($expectedRemainingQuantity, $currQuantity, "The expected remaining items in the cart does not match the actual quantity");
  }
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = RemoveItemFromCart::makeCall();

    $this->assertMatchesRegularExpression('/\"INVALID_ENTRY\"/', $response, "Meant to receive an INVALID_ENTRY response");
  }
}