<?php

use App\GetListItems;
use \PHPUnit\Framework\TestCase;
use App\AddListToCart;
use App\GetActiveCart;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\AddListToCart
 * @covers \App\GetListItems
 * @covers \App\GetActiveCart
 * @covers App\GVM
 * @depends GetListItemsTest::testValidCall
 * @depends GetListItemsTest::testInvalidCall
 * @depends GetActiveCartTest::testValidCall
 * @depends GetActiveCartTest::testInvalidCall
 */
class AddListToCartTest extends \PHPUnit\Framework\TestCase
{
  private static function findInCart(array $activeCartArr, $itemID)
  {
    for ($dex = 0; $dex < count($activeCartArr); ++$dex) {
      $cartItemObj = (object) $activeCartArr[$dex];
      if ((string) $cartItemObj->itemID == $itemID) {
        return $dex;
      }
    }

    return -1;
  }

  private static function joinListsToArray(string $activeCartJson, string $listItemsJson)
  {
    // Convert them to arrays
    $activeCartArr = (array) json_decode($activeCartJson);
    $listItemsArr = (array) json_decode($listItemsJson);
    $cartAppendArr = array();

    // For each item to add
    for ($listDex = 0; $listDex < count($listItemsArr); ++$listDex) {
      $listItemObj = (object) $listItemsArr[$listDex];

      // Check if it exists in the cart
      $cartDex = self::findInCart($activeCartArr, (string) $listItemObj->itemID);

      // If not found, add to a temp array for appending to at the end
      if ($cartDex == -1) {
        $cartAppendArr[] = (object) $listItemsArr[$listDex];
      }
      // Otherwise, update the active cart's count val
      // The update can only happen by replacing the index found in the array
      else {
        $cartItemObj = (object) $activeCartArr[$cartDex];
        $cartItemObj->count += $listItemObj->count;

        $activeCartArr[$cartDex] = $cartItemObj;
      }
    }

    // Add the new items to the cart
    for ($addDex = 0; $addDex < count($cartAppendArr); ++$addDex) {
      $activeCartArr[] = $cartAppendArr[$addDex];
    }

    return $activeCartArr;
  }

  private static function writeRequest($objRequest)
  {
    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  private static function generateInvalidRequest()
  {
    $faker = Faker\Factory::create();
    $objRequest = TestInput::getUserList();

    $objRequest->data->listID = $faker->uuid(); // give a random uuid

    $jsonString = json_encode($objRequest);

    TestInput::writeInput(TestInput::$POST, INPUT_TEST_FILE, $jsonString);

  }

  private static function generateAddToListRequest()
  {
    $objRequest = TestInput::getUserList();

    self::writeRequest($objRequest);
    return $objRequest;
  }

  private function doCartsMatch(array $expectedCartArr, array $updatedCartArr)
  {
    // Don't need to check if array sizes don't match
    if (count($expectedCartArr) != count($updatedCartArr)) {
      TestInput::log("SIZES DON'T MATCH ".count($expectedCartArr)." vs ".count($updatedCartArr));

      return false;
    }

    // For each item to check for
    for ($checkDex = 0; $checkDex < count($expectedCartArr); ++$checkDex) {
      $expectedCartItemObj = (object) $expectedCartArr[$checkDex];

      // Check if it exists in the returned cart
      $searchCartDex = self::findInCart($updatedCartArr, $expectedCartItemObj->itemID);

      // Return false if not found
      if ($searchCartDex == -1) {
        TestInput::log("ITEM ID NOT FOUND IN CART : ".$expectedCartItemObj->itemID);

        return false;
      }
      // Otherwise, return false if the counts don't match
      else {
        $updatedCartItemObj = (object) $updatedCartArr[$searchCartDex];

        if ($expectedCartItemObj->count != $updatedCartItemObj->count) {
          TestInput::log("Count's don't match : ".$expectedCartItemObj->count." vs ".$updatedCartItemObj->count);

          return false;
        }
      }
    }

    // Return true, all items match
    return true;
  }

  /**
   * @test
   */
  public function testValidCall()
  {
    $requestObj = self::generateAddToListRequest();

    // First retrieve the active cart and list to be appended with
    $activeCartJson = GetActiveCart::makeCall();
    $listItemsJson = GetListItems::makeCall();
    $expectedCartArr = self::joinListsToArray($activeCartJson, $listItemsJson);

    $responseNotification = AddListToCart::makeCall();
    $updatedCartJson = GetActiveCart::makeCall();
    $updatedCartArr = (array) json_decode($updatedCartJson);

    $this->assertMatchesRegularExpression('/\"LIST_ADDED\"/', $responseNotification, "Meant to receive an LIST_ADDED response");
    $this->assertTrue($this->doCartsMatch($expectedCartArr, $updatedCartArr), "The received updated cart does not match the expected one");
  }
  /**
   * @test
   */
  public function testInvalidCall()
  {
    self::generateInvalidRequest();

    $response = AddListToCart::makeCall();

    $this->assertMatchesRegularExpression('/\"LIST_USER_MISMTCH\"/', $response, "Meant to receive an LIST_USER_MISMTCH response");
  }


}