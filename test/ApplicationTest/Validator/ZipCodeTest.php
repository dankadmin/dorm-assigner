<?php
/**
  * StudentController Source Code
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Validator
  * @subpackage ZipCode
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace ApplicationTest\Validator;

use Application\Validator\ZipCode;

/**
  * Student Controller
  *
  * Handles details for forms for updating and creating students
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Validator
  * @subpackage ZipCode
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class ZipCodeTest extends \PHPUnit_Framework_TestCase
{
    /** 
      * Test that validator accepts valid zip codes
      *
      * @param $text String to test
      *
      * @dataProvider testAcceptsValidStringsProvider
      */
    public function testAcceptsValidStrings($text)
    {
        $zip_code = new ZipCode();
        
        $this->assertTrue($zip_code->isValid($text));
    }


    /**
      * Data provider for testAcceptsValidStrings
      *
      * @return array
      */
    public function testAcceptsValidStringsProvider()
    {
        return array(
            array('12345'),
            array('11111'),
            array('54321'),
            array('22222'),
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
        $zip_code = new ZipCode();
        
        $this->assertFalse($zip_code->isValid($text));

        $this->assertContains($error, $zip_code->getMessages());
    }

    /**
      * Data provider for testAcceptsValidStrings
      *
      * @return array
      */
    public function testFailsInvalidStringsWithErrorProvider()
    {
        return array(
            array('1234', "Zip code must be exactly 5 characters"),
            array('123a', "Valid zip code must include only digits"),
            array('123456', "Zip code must be exactly 5 characters"),
            array('123456', "Zip code must be exactly 5 characters"),
            array('1234g', "Valid zip code must include only digits"),
            array('Letters and too long', "Valid zip code must include only digits"),
            array('Letters and too long', "Zip code must be exactly 5 characters"),
            array('1234a', "Valid zip code must include only digits"),
            array('1234A', "Valid zip code must include only digits"),
            array('1234.', "Valid zip code must include only digits"),
            array('1234_', "Valid zip code must include only digits"),
            array('1234 ', "Valid zip code must include only digits"),
            array('12345 ', "Valid zip code must include only digits"),
            array('', "Zip code must be exactly 5 characters"),
            array(' ', "Zip code must be exactly 5 characters"),
            array(' ', "Valid zip code must include only digits"),
            array(' 1', "Zip code must be exactly 5 characters"),
            array(' 1', "Valid zip code must include only digits"),
        );
    }
}
