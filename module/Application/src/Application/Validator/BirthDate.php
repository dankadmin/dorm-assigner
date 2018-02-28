<?php
/** 
  * Birth Date Validator Source Code
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Validator
  * @subpackage BirthDate
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace Application\Validator;

use Zend\Validator\AbstractValidator;

/** 
  * Student ID Validator
  *
  * Validate date of birth
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Validator
  * @subpackage BirthDate
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class BirthDate extends AbstractValidator
{
    const FORMAT = 'format';
    const OLD = 'old';
    const YOUNG = 'young';
    const NOTDATE = 'notdate';

    protected $messageTemplates = array(
        self::FORMAT => "Date must be in the format YYYY-mm-dd",
        self::OLD => "Date cannot be older than 100 years",
        self::YOUNG => "Date cannot be younger than 10 years",
        self::NOTDATE => "Date must be in a valid date",
    );

    /**
      * Check validity
      *
      * Confirm that value is is a valid date, in the correct format,
      * between 10 and 100 years ago.
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
        if (preg_match('/^([0-9]{4})-[0-2][0-9]-[0-3][0-9]$/', $value, $matches) !== 1) {
            $this->error(self::FORMAT);
            $isValid = false;
            return $isValid;
        }

        $year = $matches[1];

        $date = date('Y-m-d', strtotime($value));

        if ($date != $value) {
            $this->error(self::NOTDATE);
            $isValid = false;
        }

        if (strtotime('-100 years') > strtotime($value)) {
            $this->error(self::OLD);
            $isValid = false;
        }

        if (strtotime('-10 years') < strtotime($value)) {
            $this->error(self::YOUNG);
            $isValid = false;
        }


        return $isValid;
    }
}
