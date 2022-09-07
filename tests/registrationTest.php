<?php
    // use TestInput;
    use \PHPUnit\Framework\TestCase;
    use App\Registration;
    use App\GVM;
    
    require_once(__DIR__.'/../src/GVM.php');
    require_once('inputHandler.php');

    class RegistrationTest extends TestCase {

      static function generateInput() : void
      {
        $faker = TestInput::getFaker();

        $objContent = new stdClass();
        
        $bodyContent = new stdClass();
        $bodyContent->firstName = $faker->firstName();
        $bodyContent->lastName = $faker->lastName();
        $bodyContent->userEmail = $faker->email();
        $bodyContent->userPassword = $faker->password(10, 15);
        $bodyContent->securityQuestion = $faker->sentence();
        $bodyContent->securityAnswer = $faker->word();

        $objContent->data = $bodyContent;

        $jsonString = json_encode($objContent);

        TestInput::writeInput(INPUT_TEST_FILE, $jsonString);
      }

      public function testMakeCall() 
      {
        self::generateInput();
        // $registration = new Registration();
        // $jsonString = $registration->makeCall(self::FILENAME);
        // $jsonObject = json_decode($jsonString)[0];

        $_SERVER["REQUEST_METHOD"] = "POST";
        echo json_decode(Registration::makeCall(INPUT_TEST_FILE));

        $this->assertClassHasAttribute('userID', json_decode(Registration::makeCall(self::FILENAME)));
      }

    }