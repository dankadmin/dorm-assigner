<?php
/** 
  * Status Source Code
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Validator
  * @subpackage Status
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace Application\Validator;

use Zend\Validator\AbstractValidator;

/** 
  * Status Source Code
  *
  * Validate status as active or inactive.
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Validator
  * @subpackage Status
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class Status extends AbstractValidator
{
    const INVALID = 'invalid';

    protected $messageTemplates = array(
        self::INVALID => "The only valid statuses are 'active' and 'inactive'.",
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

        if (! preg_match('/^(in)?active$/', $value)) {
            $this->error(self::INVALID);
            $isValid = false;
        }

        return $isValid;
    }
}
