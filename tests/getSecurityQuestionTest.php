<?php

// use TestInput;
use \PHPUnit\Framework\TestCase;
use App\GetSecurityQuestion;

require_once(__DIR__ . '/../src/GVM.php');
require_once('inputHandler.php');

/**
 * @covers GetSecurityQuestion
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
   * @covers GetSecurityQuestion::makeCall
   */
  public function testMakeCall()
  {
    self::generateValidInput();

    $_SERVER["REQUEST_METHOD"] = "POST";

    $this->expectOutputRegex('/What are you missing if you have everything?/');
    GetSecurityQuestion::makeCall();
  }

}