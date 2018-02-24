<?php

namespace Application\Validator;

use Zend\Validator\AbstractValidator;

class AlNumSpaces extends AbstractValidator
{
    const CHARS = 'chars';
    const LONG = 'long';
    const SHORT = 'short';

    protected $messageTemplates = array(
        self::CHARS => "Input contains invalid characters",
        self::LONG => "Input must be no more than 200 characters in length",
        self::SHORT => "'%value%' must be at least 3 characters in length",
    );

    public function isValid($value)
    {
        $this->setValue($value);

        $isValid = true;

        if (preg_match('/[^a-zA-Z0-9 ]/', $value)) {
            $this->error(self::CHARS);
            $isValid = false;
        }


        if (strlen($value) > 200) {
            $this->error(self::LONG);
            $isValid = false;
        }

        if (strlen($value) < 3) {
            $this->error(self::SHORT);
            $isValid = false;
        }


        return $isValid;
    }
}
