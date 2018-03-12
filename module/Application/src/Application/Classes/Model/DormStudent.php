<?php
/**
  * Dorm Student Source Code
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Classes\Model
  * @subpackage DormStudent
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace Application\Classes\Model;

use Propel\Runtime\ActiveRecord\ActiveRecordInterface;

/**
  * Dorm Student
  *
  * Repository for Student information from Student and ContactInfo
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Classes\Model
  * @subpackage DormStudent
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class DormStudent
{

    /** @var array $_student Student model. */
    private $_student;
    /** @var array $_contact Student model. */
    private $_contact;


    /**
      * Constructor
      *
      * Set the list of available states.
      *
      */
    public function __construct(\PipelinePropel\Student $student_model, \PipelinePropel\ContactInfo $contact_info_model)
    {
        $this->_student = $student_model;
        $this->_contact = $contact_info_model;
    }

    /**
      * getId
      *
      * @return string
      */
    public function getId()
    {
        return $this->_student->getId();
    }

    /**
      * setFirstName
      *
      * @param string $value
      */
    public function setFirstName($value)
    {
        $this->_student->setFirstName($value);
    }

    /**
      * getFirstName
      *
      * @return string
      */
    public function getFirstName()
    {
        return $this->_student->getFirstName();
    }

    /**
      * setLastName
      *
      * @param string $value
      */
    public function setLastName($value)
    {
        $this->_student->setLastName($value);
    }

    /**
      * getLastName
      *
      * @return string
      */
    public function getLastName()
    {
        return $this->_student->getLastName();
    }

    /**
      * setAddress1
      *
      * @param string $value
      */
    public function setAddress1($value)
    {
        $this->_contact->setAddress1($value);
    }

    /**
      * getAddress1
      *
      * @return string
      */
    public function getAddress1()
    {
        return $this->_contact->getAddress1();
    }

    /**
      * setAddress2
      *
      * @param string $value
      */
    public function setAddress2($value)
    {
        $this->_contact->setAddress2($value);
    }

    /**
      * getAddress2
      *
      * @return string
      */
    public function getAddress2()
    {
        return $this->_contact->getAddress2();
    }

    /**
      * setCity
      *
      * @param string $value
      */
    public function setCity($value)
    {
        $this->_contact->setCity($value);
    }

    /**
      * getCity
      *
      * @return string
      */
    public function getCity()
    {
        return $this->_contact->getCity();
    }

    /**
      * setState
      *
      * @param string $value
      */
    public function setState($value)
    {
        $this->_contact->setState($value);
    }

    /**
      * getState
      *
      * @return string
      */
    public function getState()
    {
        return $this->_contact->getState();
    }

    /**
      * setZip
      *
      * @param string $value
      */
    public function setZip($value)
    {
        $this->_contact->setZip($value);
    }

    /**
      * getZip
      *
      * @return string
      */
    public function getZip()
    {
        return $this->_contact->getZip();
    }

    /**
      * setGender
      *
      * @param string $value
      */
    public function setGender($value)
    {
        $this->_student->setGender($value);
    }

    /**
      * getGender
      *
      * @return string
      */
    public function getGender()
    {
        return $this->_student->getGender();
    }

    /**
      * setStudentNum
      *
      * @param string $value
      */
    public function setStudentNum($value)
    {
        $this->_student->setStudentNum($value);
    }

    /**
      * getStudentNum
      *
      * @return string
      */
    public function getStudentNum()
    {
        return $this->_student->getStudentNum();
    }

    /**
      * setBirthDate
      *
      * @param string $value
      */
    public function setBirthDate($value)
    {
        $this->_student->setBirthDate($value);
    }

    /**
      * getBirthDate
      *
      * @return string
      */
    public function getBirthDate()
    {
        return $this->_student->getBirthDate();
    }

    /**
      * setPhoneNumber
      *
      * @param string $value
      */
    public function setPhoneNumber($value)
    {
        $this->_contact->setPhoneNumber($value);
    }

    /**
      * getPhoneNumber
      *
      * @return string
      */
    public function getPhoneNumber()
    {
        return $this->_contact->getPhoneNumber();
    }

    /**
      * setStatus
      *
      * @param string $value
      */
    public function setStatus($value)
    {
        $this->_student->setStatus($value);
    }

    /**
      * getStatus
      *
      * @return string
      */
    public function getStatus()
    {
        return $this->_student->getStatus();
    }

    /**
      * exchangeArray
      *
      * Accepts array of containing table data and adds it to the appropriate model.
      *
      * @param array $data
      */
    public function exchangeArray($data)
    {
        $this->setFirstName((isset($data['first_name'])) ? $data['first_name'] : null);
        $this->setLastName((isset($data['last_name'])) ? $data['last_name'] : null);
        $this->setAddress1((isset($data['address_1'])) ? $data['address_1'] : null);
        $this->setAddress2((isset($data['address_2'])) ? $data['address_2'] : null);
        $this->setCity((isset($data['city'])) ? $data['city'] : null);
        $this->setState((isset($data['state'])) ? $data['state'] : null);
        $this->setZip((isset($data['zip'])) ? $data['zip'] : null);
        $this->setGender((isset($data['gender'])) ? $data['gender'] : null);
        $this->setStudentNum((isset($data['student_num'])) ? $data['student_num'] : null);
        $this->setBirthDate((isset($data['birth_date'])) ? $data['birth_date'] : null);
        $this->setPhoneNumber((isset($data['phone_number'])) ? $data['phone_number'] : null);
        $this->setStatus((isset($data['status'])) ? $data['status'] : null);
    }

    /**
      * getArrayCopy
      *
      * Return Array representing student information
      *
      * @return array
      */
    public function getArrayCopy()
    {
        return array(
            'id' => $this->getId(),
            'full_name' => $this->getFullName(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'address_1' => $this->getAddress1(),
            'address_2' => $this->getAddress2(),
            'city' => $this->getCity(),
            'state' => $this->getState(),
            'zip' => $this->getZip(),
            'gender' => $this->getGender(),
            'student_num' => $this->getStudentNum(),
            'birth_date' => $this->getBirthDate()->format('Y-m-d'),
            'phone_number' => $this->getPhoneNumber(),
            'status' => $this->getStatus(),
        );
    }

    /**
      * getFullName
      *
      * @return string
      */
    public function getFullName()
    {
        return $this->getFirstName() . " " . $this->getLastName();
    }

    /**
      * Save
      *
      * Save data to model
      */
    public function save()
    {
        $this->_student->save();
        $this->_contact->setStudentId($this->_student->getId());
        $this->_contact->save();
    }

    /**
      * hardDelete
      *
      * Forces deletion of Student and ContactInfo. This function should only be used during Unit Testing
      * until proper Mocking is available.
      */
    public function hardDelete()
    {
        $this->_contact->delete();
        $this->_student->delete();
    }
}
