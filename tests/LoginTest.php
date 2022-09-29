<?php
    // use TestInput;
    use \PHPUnit\Framework\TestCase;
    use App\Login;
require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers \App\Login
 * @covers \RequestObject
 * @covers App\GVM
 */
    class LoginTest extends TestCase {

      static function generateValidInput() : void
      {
        $objContent = TestInput::getExistingUser();

        $jsonString = json_encode($objContent);

        TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
      }
      
      static function generateInvalidInput() : void
      {
        $objContent = TestInput::getNonExistingUser();

        $jsonString = json_encode($objContent);

        TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
      }


      /**
       * @test
       */
      public function testValidMakeCall()
      {
        self::generateValidInput();

        $_SERVER["REQUEST_METHOD"] = "POST";

        $this->expectOutputRegex('/userID/');
        Login::makeCall();
      }
      /**
       * @test
       */
      public function testInvalidMakeCall()
      {
        self::generateInvalidInput();

        $_SERVER["REQUEST_METHOD"] = "POST";

        $this->expectOutputRegex('//');
        Login::makeCall();
      }

    }