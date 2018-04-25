<?php
/**
  * AssignmentForm Source Code
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Form
  * @subpackage AssignmentForm
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Application\Classes\States;
use Application\Classes\Model\DormStudentQuery;

/**
  * Assignment Form
  *
  * Handles details for forms for updating and creating students
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Form
  * @subpackage AssignmentForm
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class AssignmentForm extends Form
{
    /** @var boolean $_is_update Is the form being used for an update. */
    private $_is_update;

    /**
      * Constructor
      *
      * @param $name Name of form. To be used as the id. Defaults to 'student'.
      */
    public function __construct($available_rooms=array('none' => 'None'), $name = 'assignment')
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
            'name' => 'room_id',
            'type' => 'Select',
            'options' => array(
                'label' => 'Room',
                'required' => true,
                'value_options' => $available_rooms
            ),
        ));
        $inputFilter->add(array(
            'name'     => 'room_id',
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

  /**
    * setIsUpdate
    *
    * Is Form Valid
    *
    * @param boolean $value Set whether this form is an update.
    */
    public function setIsUpdate($value = true)
    {
        $this->_is_update = $value;
    }

  /**
    * isValid
    *
    * Is Form Valid
    *
    * @return boolean
    */
    public function isValid()
    {
        $valid = parent::isValid();
        return true;

        /*
        $data = $this->getData();

        $student_errors = $this->get('student_num')->getMessages();

        $first_initial = strtoupper(substr($data['first_name'], 0, 1));
        $last_initial = strtoupper(substr($data['last_name'], 0, 1));
        $student_num = $data['student_num'];

        if (
            ! preg_match(
                '/^' . $first_initial . $last_initial . '[0-9]{6}$/',
                $student_num
            )
        ) {
            array_push($student_errors, 'Student Number does not include first and last initials.');
            $valid = false;
        }

        if ($this->_is_update) {
            return $valid;
        }

        $student_query = new DormStudentQuery();

        if ($student_query->findByStudentNum($student_num) != NULL) {
            array_push(
                $student_errors,
                "Student already exists with number '$student_num'."
            );
            $valid = false;
        }

        $this->get('student_num')->setMessages($student_errors);
        return $valid;
        */
    }
}



