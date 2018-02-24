<?php
/** 
  * Gender Source Code
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Validator
  * @subpackage Gender
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace Application\Validator;

use Zend\Validator\AbstractValidator;

/** 
  * Gender Source Code
  *
  * Validate gender as male or female.
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Validator
  * @subpackage Gender
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class Gender extends AbstractValidator
{
    const INVALID = 'invalid';

    protected $messageTemplates = array(
        self::INVALID => "The only valid genders are 'male' and 'female'.",
    );

    /**
      * Check validity
      *
      * Confirm that value is either male or female.
      *
      * @param $value String to be tested
      *
      * @ return boolean Whether or not value is valid.
      */
    public function isValid($value)
    {
        $this->setValue($value);

        $isValid = true;

        if (! preg_match('/^(male|female)$/', $value)) {
            $this->error(self::INVALID);
            $isValid = false;
        }

        return $isValid;
    }
}
