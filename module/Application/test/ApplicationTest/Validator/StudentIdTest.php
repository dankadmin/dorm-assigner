<?php
/**
  * Student ID Validator Test Source Code
  *
  * @category DormAssigner
  * @package DormAssigner\Test\Application\Validator
  * @subpackage StudentId
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace ApplicationTest\Validator;

use Application\Validator\StudentId;

/**
  * Student ID Validator Test
  *
  * Tests Student ID Validator
  *
  * @category DormAssigner
  * @package DormAssigner\\TestApplication\Validator
  * @subpackage StudentId
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class StudentIdTest extends \PHPUnit_Framework_TestCase
{
    /** 
      * Test that validator accepts valid Student IDs
      *
      * @param $text String to test
      *
      * @dataProvider testAcceptsValidStringsProvider
      */
    public function testAcceptsValidStudentIds($text)
    {
        $student_id = new StudentId();
        
        $this->assertTrue($student_id->isValid($text));
    }


    /**
      * Data provider for testAcceptsValidStrings
      *
      * @return array
      */
    public function testAcceptsValidStringsProvider()
    {
        return array(
            array('AB123456'),
            array('ZZ111116'),
            array('CD000000'),
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
        $student_id = new StudentId();
        
        $this->assertFalse($student_id->isValid($text));

        $this->assertContains($error, $student_id->getMessages());
    }

    /**
      * Data provider for testAcceptsValidStrings
      *
      * @return array
      */
    public function testFailsInvalidStringsWithErrorProvider()
    {
        return array(
            array('1234', "Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit."),
            array('AB12345', "Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit."),
            array('AB1234567', "Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit."),
            array('aB123456', "Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit."),
            array('B1234567', "Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit."),
            array('ABC12345', "Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit."),
            array('AB12345.', "Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit."),
            array('.B123456', "Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit."),
            array('AB12345 ', "Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit."),
            array('AB123456 ', "Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit."),
            array(' B123456', "Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit."),
            array(' AB123456', "Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit."),
        );
    }
}
