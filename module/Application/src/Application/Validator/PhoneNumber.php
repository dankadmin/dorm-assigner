<?php
/** 
  * Phone Number Validator Source Code
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Validator
  * @subpackage PhoneNumber
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace Application\Validator;

use Zend\Validator\AbstractValidator;

/** 
  * Phone Number Validator
  *
  * Validate phone number
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Validator
  * @subpackage PhoneNumber
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class PhoneNumber extends AbstractValidator
{
    const FORMAT = 'format';

    protected $messageTemplates = array(
        self::FORMAT => "Phone number must be exactly 10 digits, and no other characters",
    );

    /**
      * Check validity
      *
      * Confirm that value is is a valid phone number.
      *
      * @param $value String to be tested
      *
      * @ return boolean Whether or not value is valid.
      */
    public function isValid($value)
    {
        $this->setValue($value);

        $isValid = true;

        $matches = array();
        if (preg_match('/^[0-9]{10}$/', $value, $matches) !== 1) {
            $this->error(self::FORMAT);
            $isValid = false;
            return $isValid;
        }


        return $isValid;
    }
}
