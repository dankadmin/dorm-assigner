<?php

namespace Application\Validator;

use Zend\Validator\AbstractValidator;

class ZipCode extends AbstractValidator
{
    const CHARS = 'chars';
    const LENGTH = 'length';

    protected $messageTemplates = array(
        self::CHARS => "Valid zip code must include only digits",
        self::LENGTH => "Zip code must be exactly 5 characters",
    );

    public function isValid($value)
    {
        $this->setValue($value);

        $isValid = true;

        if (! preg_match('/^[0-9]+$/', $value)) {
            $this->error(self::CHARS);
            $isValid = false;
        }


        if (strlen($value) > 5 || strlen($value) < 5) {
            $this->error(self::LENGTH);
            $isValid = false;
        }

        return $isValid;
    }
}
