<?php

namespace ApplicationTest\Validator;

use Application\Validator\SimpleString;

class SimpleStringTest extends \PHPUnit_Framework_TestCase
{
    /**
      * @dataProvider testAcceptsValidStringsProvider
      */
    public function testAcceptsValidStrings($text)
    {
        $simple_string = new SimpleString();
        
        $this->assertTrue($simple_string->isValid($text));
    }

    public function testAcceptsValidStringsProvider()
    {
        return array(
            array('OneWord'),
            array('Two words'),
            array('Moderately long string, but it is not too long.'),
        );
    }

    /**
      * @dataProvider testFailsInvalidStringsWithErrorProvider
      */
    public function testFailsInvalidStringsWithError($text, $error)
    {
        $simple_string = new SimpleString();
        
        $this->assertFalse($simple_string->isValid($text));

        $this->assertContains($error, $simple_string->getMessages());
    }

    public function testFailsInvalidStringsWithErrorProvider()
    {
        return array(
            array('sh', "'sh' must be at least 3 characters in length"),
            array('s!', "'s!' must be at least 3 characters in length"),
            array('s!', "Input contains invalid characters"),
            array('This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. ', "Input must be no more than 200 characters in length"),
            array('Long sting with ! in it. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. ', "Input must be no more than 200 characters in length"),
            array('Long sting with ! in it. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. This is a very long string. I am testing string length. ', "Input contains invalid characters"),
            array('Contains !', 'Input contains invalid characters'),
            array('Contains "', 'Input contains invalid characters'),
            array('Contains <', 'Input contains invalid characters'),
            array('Contains `', 'Input contains invalid characters'),
        );
    }
}
