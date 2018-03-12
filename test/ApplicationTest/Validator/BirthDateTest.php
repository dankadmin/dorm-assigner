<?php
/**
  * Birth Date Validation Test Source Code
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Validator
  * @subpackage BirthDate
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace ApplicationTest\Validator;

use Application\Validator\BirthDate;

/**
  * Birth Date Validation Test
  *
  * Test that Birth Date is in a reasonable format.
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Validator
  * @subpackage BirthDate
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class BirthDateTest extends \PHPUnit_Framework_TestCase
{
    /** 
      * Test that validator accepts valid birth dates
      *
      * @param $text String to test
      *
      * @dataProvider testAcceptsValidStringsProvider
      */
    public function testAcceptsValidStrings($text)
    {
        $birth_date = new BirthDate();
        
        $this->assertTrue($birth_date->isValid($text));
    }


    /**
      * Data provider for testAcceptsValidStrings
      *
      * @return array
      */
    public function testAcceptsValidStringsProvider()
    {
        return array(
            array('1970-01-01'),
            array('1995-05-23'),
            array('2001-10-31'),
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
        $birth_date = new BirthDate();
        
        $this->assertFalse($birth_date->isValid($text));

        $this->assertContains($error, $birth_date->getMessages());
    }

    /**
      * Data provider for testAcceptsValidStrings
      *
      * @return array
      */
    public function testFailsInvalidStringsWithErrorProvider()
    {
        return array(
            array('1234', "Date must be in the format YYYY-mm-dd"),
            array('19700101', "Date must be in the format YYYY-mm-dd"),
            array('01-01-1970', "Date must be in the format YYYY-mm-dd"),
            array('1870-01-01', "Date cannot be older than 100 years"),
            array('3070-01-01', "Date cannot be younger than 10 years"),
            array('1970-31-01', "Date must be in the format YYYY-mm-dd"),
            array('1970-13-01', "Date must be in a valid date"),
            array('1970-02-30', "Date must be in a valid date"),
        );
    }
}
