<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;


class StudentForm extends Form
{
    public function __construct($name = 'student')
    {
        parent::__construct($name);

        $inputFilter = new InputFilter();

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $inputFilter->add(array(
            'name'     => 'id',
            'required' => true,
            'filters'  => array(
             array('name' => 'Int'),
            ),
        ));

        $this->add(array(
            'name' => 'first_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'First Name',
                'required' => true,
            ),
        ));
        $inputFilter->add(array(
            'name'     => 'first_name',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'Application\Validator\SimpleString',
                    'options' => array(
                        'encoding' => 'UTF-8',
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'last_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Last Name',
                'required' => true,
            ),
        ));
        $inputFilter->add(array(
            'name'     => 'last_name',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'Application\Validator\SimpleString',
                    'options' => array(
                        'encoding' => 'UTF-8',
                    ),
                ),
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

        $this->setInputFilter($inputFilter);
    }
}



