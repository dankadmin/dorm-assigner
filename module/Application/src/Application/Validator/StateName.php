<?php

namespace Application\Validator;

use Zend\Validator\AbstractValidator;
use Application\Classes\States;

class StateName extends AbstractValidator
{
    const NOTSTATE = 'notstate';

    protected $messageTemplates = array(
        self::NOTSTATE => "Value given is not a valid state",
    );

    public function isValid($value)
    {
        $this->setValue($value);

        $states = new States();
        $state_names = $states->getArray();

        if (in_array($value, $state_names)) {
            return true;
        }

        $this->error(self::NOTSTATE);

        return false;
    }
}
