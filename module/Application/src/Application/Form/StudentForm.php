<?php

namespace Application\Form;

use Zend\Form\Form;

class StudentForm extends Form
{
    public function __construct($name = 'student')
    {
        parent::__construct($name);

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'first_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'First Name',
                'required' => true,
                'validation' => 'string',
                'pattern' => '^[a-zA-Z0-9., -]{1,100}$',
            ),
        ));
        $this->add(array(
            'name' => 'last_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Last Name',
                'required' => true,
                'pattern' => '^[a-zA-Z0-9., -]{1,100}$',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Add Student',
                'caption' => 'Add Student',
                'id' => 'submitbutton',
            ),
         ));
    }
}
