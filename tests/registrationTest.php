<?php
    // use TestInput;
    use \PHPUnit\Framework\TestCase;
    use App\Registration;
    
    require_once(__DIR__.'/../src/GVM.php');
    require_once('inputHandler.php');

/**
 * @covers Registration
 */
    class RegistrationTest extends TestCase {

      static function generateValidInput() : void
      {
        $objContent = TestInput::getNewUser();

        $jsonString = json_encode($objContent);

        TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
      }

      /**
       * @covers RegistrationTest::makeCall
       */
      public function testMakeCall() 
      {
        self::generateValidInput();

        $_SERVER["REQUEST_METHOD"] = "POST";

        $this->expectOutputRegex('/userID/');
        Registration::makeCall();
      }

    }