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

    }
}



