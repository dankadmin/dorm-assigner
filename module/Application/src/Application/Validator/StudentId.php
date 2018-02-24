<?php
/** 
  * StudentId Source Code
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Validator
  * @subpackage StudentId
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace Application\Validator;

use Zend\Validator\AbstractValidator;

/** 
  * Student ID Validator
  *
  * Validate Student ID
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Validator
  * @subpackage StudentId
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class StudentId extends AbstractValidator
{
    const FORMAT = 'FORMAT';

    protected $messageTemplates = array(
        self::FORMAT => "Student ID must be in format LLDDDDDD, where L is a capital letter, and D is a digit.",
    );

    /**
      * Check validity
      *
      * Confirm that value is is of format LLDDDDDD where L is a letter and D is a digit.
      *
      * @param $value String to be tested
      *
      * @ return boolean Whether or not value is valid.
      */
    public function isValid($value)
    {
        $this->setValue($value);

        $isValid = true;

        if (! preg_match('/^[A-Z]{2}[0-9]{6}$/', $value)) {
            $this->error(self::FORMAT);
            $isValid = false;
        }

        return $isValid;
    }
}
