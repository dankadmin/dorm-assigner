<?php
/**
  * Phone Number Validation Test Source Code
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Validator
  * @subpackage PhoneNumber
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace ApplicationTest\Validator;

use Application\Validator\PhoneNumber;

/**
  * Phone Number Validation Test
  *
  * Test that Birth Date is in a reasonable format.
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Validator
  * @subpackage PhoneNumber
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class PhoneNumberTest extends \PHPUnit_Framework_TestCase
{
    /** 
      * Test that validator accepts valid phone number
      *
      * @param $text String to test
      *
      * @dataProvider testAcceptsValidStringsProvider
      */
    public function testAcceptsValidStrings($text)
    {
        $phone_number = new PhoneNumber();
        
        $this->assertTrue($phone_number->isValid($text));
    }


    /**
      * Data provider for testAcceptsValidStrings
      *
      * @return array
      */
    public function testAcceptsValidStringsProvider()
    {
        return array(
            array('1112223333'),
            array('7571231234'),
            array('8885555555'),
        );
    }

    /**
      * Test that validator fails with invalid strings
      *
      * Confirms that validator fails with invalid strings and also
      * returns the correct error message.
      *
      * @param $text String to test
      * @param $error The expected error message
      *
      * @dataProvider testFailsInvalidStringsWithErrorProvider
      */
    public function testFailsInvalidStringsWithError($text, $error)
    {
        $phone_number = new PhoneNumber();
        
        $this->assertFalse($phone_number->isValid($text));

        $this->assertContains($error, $phone_number->getMessages());
    }

    /**
      * Data provider for testAcceptsValidStrings
      *
      * @return array
      */
    public function testFailsInvalidStringsWithErrorProvider()
    {
        return array(
            array('1234', "Phone number must be exactly 10 digits, and no other characters"),
            array('12223334444', "Phone number must be exactly 10 digits, and no other characters"),
            array('1112223333 ', "Phone number must be exactly 10 digits, and no other characters"),
            array(' 1112223333', "Phone number must be exactly 10 digits, and no other characters"),
            array('a2223334444', "Phone number must be exactly 10 digits, and no other characters"),
            array('1222333444a', "Phone number must be exactly 10 digits, and no other characters"),
        );
    }
}
