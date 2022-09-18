<?php
    // use TestInput;
    use \PHPUnit\Framework\TestCase;
    use App\Registration;

    require_once(__DIR__.'/../vendor/autoload.php');
require_once('TestInput.php');

/**
 * @covers App\Registration
 * @covers \RequestObject
 * @covers \GVM
 */
    class RegistrationTest extends TestCase {

      static function generateValidInput()
      {
        $objContent = TestInput::getValidNewUser();

        $jsonString = json_encode($objContent);

        TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
      }
      static function generateInvalidInput()
      {
        $objContent = TestInput::getInvalidNewUser();

        $jsonString = json_encode($objContent);

        TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
      }

      /**
       * @test
       */
      public function testValidMakeCall()
      {
        $_SERVER["REQUEST_METHOD"] = "POST";

        self::generateValidInput();
        $this->expectOutputRegex('/userID/');
        Registration::makeCall();
      }
      /**
       * @test
       */
      public function testInvalidMakeCall()
      {
        $_SERVER["REQUEST_METHOD"] = "POST";

        self::generateInvalidInput();
        $this->expectOutputRegex('//');
        Registration::makeCall();
      }

    }