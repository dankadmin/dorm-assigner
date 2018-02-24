<?php
/**
  * StudentController Source Code
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Validator
  * @subpackage AlNumSpaces
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace ApplicationTest\Validator;

use Application\Validator\AlNumSpaces;

/**
  * Student Controller
  *
  * Handles details for forms for updating and creating students
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Validator
  * @subpackage AlNumSpaces
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class AlNumSpacesTest extends \PHPUnit_Framework_TestCase
{
    /** 
      * Test that validator accepts valid strings
      *
      * @param $text String to test
      *
      * @dataProvider testAcceptsValidStringsProvider
      */
    public function testAcceptsValidStrings($text)
    {
        $alpha_num_spaces = new AlNumSpaces();
        
        $this->assertTrue($alpha_num_spaces->isValid($text));
    }


    /**
      * Data provider for testAcceptsValidStrings
      *
      * @return array
      */
    public function testAcceptsValidStringsProvider()
    {
        return array(
            array('OneWord'),
            array('Two words'),
            array('Moderately long string'),
            array('5tr1ng w1th numb3rs'),
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
        $alpha_num_spaces = new AlNumSpaces();
        
        $this->assertFalse($alpha_num_spaces->isValid($text));

        $this->assertContains($error, $alpha_num_spaces->getMessages());
    }

    /**
      * Data provider for testAcceptsValidStrings
      *
      * @return array
      */
    public function testFailsInvalidStringsWithErrorProvider()
    {
        return array(
            array('sh', "'sh' must be at least 3 characters in length"),
            array('s!', "'s!' must be at least 3 characters in length"),
            array('s!', "Input contains invalid characters"),
            array('This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. ', "Input must be no more than 200 characters in length"),
            array('Long sting with ! in it. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. ', "Input must be no more than 200 characters in length"),
            array('Long sting with ! in it. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. ', "Input contains invalid characters"),
            array('Contains ,', 'Input contains invalid characters'),
            array('Contains .', 'Input contains invalid characters'),
            array('Contains !', 'Input contains invalid characters'),
            array('Contains "', 'Input contains invalid characters'),
            array('Contains <', 'Input contains invalid characters'),
            array('Contains `', 'Input contains invalid characters'),
        );
    }
}
