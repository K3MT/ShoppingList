<?php
    // use TestInput;
    use \PHPUnit\Framework\TestCase;
    use App\Login;
require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\Login
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
       * @covers App\Login::makeCall
       * @uses RequestObject
       * @uses GVM
       */
      public function testMakeCall() 
      {
        self::generateValidInput();

        $_SERVER["REQUEST_METHOD"] = "POST";
        $out = (Login::makeCall());// + array(null);

        TestInput::log("loginTest\n".$out);

        $this->assertStringContainsString('userID', $out, "Testing valid user login failed:\n".$out."\n\n");

        self::generateValidInput();

        $_SERVER["REQUEST_METHOD"] = "POST";

        $this->expectOutputRegex('/userID/');
        Login::makeCall();
      }

    }