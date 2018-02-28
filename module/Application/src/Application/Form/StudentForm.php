<?php
/**
  * StudentForm Source Code
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Form
  * @subpackage StudentForm
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Application\Classes\States;

/**
  * Student Form
  *
  * Handles details for forms for updating and creating students
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Form
  * @subpackage StudentForm
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class StudentForm extends Form
{
    /**
      * Constructor
      *
      * @param $name Name of form. To be used as the id. Defaults to 'student'.
      */
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
            'name' => 'street',
            'type' => 'Text',
            'options' => array(
                'label' => 'Street',
                'required' => true,
            ),
        ));
        $inputFilter->add(array(
            'name'     => 'street',
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
            'name' => 'city',
            'type' => 'Text',
            'options' => array(
                'label' => 'City',
                'required' => true,
            ),
        ));
        $inputFilter->add(array(
            'name'     => 'city',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'Application\Validator\AlNumSpaces',
                    'options' => array(
                        'encoding' => 'UTF-8',
                    ),
                ),
            ),
        ));

        $states = new States();
        $state_names = $states->getArray();
        $this->add(array(
            'name' => 'state',
            'type' => 'Select',
            'options' => array(
                'label' => 'State',
                'required' => true,
                'value_options' => $state_names
            ),
        ));
        $inputFilter->add(array(
            'name'     => 'state',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'Application\Validator\StateName',
                    'options' => array(
                        'encoding' => 'UTF-8',
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'zip',
            'type' => 'Text',
            'options' => array(
                'label' => 'Zip Code',
                'required' => true,
            ),
        ));
        $inputFilter->add(array(
            'name'     => 'zip',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'Application\Validator\ZipCode',
                    'options' => array(
                        'encoding' => 'UTF-8',
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'gender',
            'type' => 'Radio',
            'options' => array(
                'label' => 'Gender',
                'required' => true,
                'value_options' => array(
                    'male' => 'Male',
                    'female' => 'Female',
                ),
            ),
        ));
        $inputFilter->add(array(
            'name'     => 'gender',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'Application\Validator\Gender',
                    'options' => array(
                        'encoding' => 'UTF-8',
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'student_num',
            'type' => 'Text',
            'options' => array(
                'label' => 'Student ID',
                'required' => true,
            ),
        ));
        $inputFilter->add(array(
            'name'     => 'student_num',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'Application\Validator\StudentId',
                    'options' => array(
                        'encoding' => 'UTF-8',
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'birth_date',
            'type' => 'Text',
            'options' => array(
                'label' => 'Date of Birth',
                'required' => true,
            ),
        ));
        $inputFilter->add(array(
            'name'     => 'birth_date',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'Application\Validator\BirthDate',
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



