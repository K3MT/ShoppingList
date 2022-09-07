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
        $objContent = TestInput::getNewUser();

        $jsonString = json_encode($objContent);

        TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
      }

      public function testMakeCall()
      {
        self::generateValidInput();
        $_SERVER["REQUEST_METHOD"] = "POST";

        $this->expectOutputRegex('/userID/');

        Registration::makeCall();
      }

    }