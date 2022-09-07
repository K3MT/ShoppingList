<?php

// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\GetSecurityQuestion;

require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\GetSecurityQuestion
 */
class GetSecurityQuestionTest extends TestCase
{

  static function generateValidInput(): void
  {
    $objContent = TestInput::getKnownSecurityQuestion();

    $jsonString = json_encode($objContent);

    TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
  }

  /**
   * @covers App\GetSecurityQuestion::makeCall
   * @uses RequestObject
   * @uses GVM
   */
  public function testMakeCall()
  {
    self::generateValidInput();

    $_SERVER["REQUEST_METHOD"] = "POST";

    $this->expectOutputRegex('/What are you missing if you have everything?/');
    GetSecurityQuestion::makeCall();
  }

}