<?php
/**
  * DormStudentQuery Source Code
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Classes\Model
  * @subpackage DormStudentQuery
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace Application\Classes\Model;

/**
  * DormStudentQuery
  *
  * Query for Student repository
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Classes\Model
  * @subpackage DormStudentQuery
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class DormStudentQuery
{

    /** @var array $_student_query Student query class name. */
    private $_student_query;
    /** @var array $_contact_query Student query class name. */
    private $_contact_query;

    /** @var array $_student_class Student model class name. */
    private $_student_class;
    /** @var array $_contact_class Student model class name. */
    private $_contact_class;

    /** @var array $_dorm_student DormStudent query class name. */
    private $_dorm_student;


    /**
      * Constructor
      *
      * Set the list of available states.
      *
      * @param string $student_query_class
      * @param string $student_class
      * @param string $contact_query_class
      * @param string $contact_class
      * @param string $dorm_student_class
      *
      */
    /*
    public function __construct(
        string $student_query_class,
        string $student_class,
        string $contact_query_class,
        string $contact_class,
        string $dorm_student_class
    )
    {
        $this->_student_query = $student_query_class;
        $this->_student_class = $student_class;
        $this->_contact_query = $contact_query_class;
        $this->_contact_class = $contact_class;

        $this->_dorm_student = $dorm_student_class;
    }
    */

    /**
      * Constructor
      *
      * Set the list of available states.
      *
      */
    public function __construct()
    {
        $this->_student_query = '\PipelinePropel\StudentQuery';
        $this->_student_class = '\PipelinePropel\Student';
        $this->_contact_query = '\PipelinePropel\ContactInfoQuery';
        $this->_contact_class = '\PipelinePropel\ContactInfo';

        $this->_dorm_student = '\Application\Classes\Model\DormStudent';
    }

    /**
      * getDormStudentFromStudent
      *
      * Creata a DormStudent instance by giving a Student record
      *
      * @param \PipelinePropel\Student $student Student record to create a DormStudent entry from.
      *
      * @return DormStudent
      */
    private function getDormStudentFromStudent($student)
    {
        $contact = $this->_contact_query::create()
            ->filterByStatus('active')
            ->findOneByStudentId($student->getId());

        if ($contact == NULL) {
            throw new DormStudentQueryException(
                'Discovered Student row, ID ' . $student->getId()
                . ', with no active ContactInfo record associated with it.'
            );
        }

        return new $this->_dorm_student($student, $contact);
    }

    /**
      * new
      *
      * Return new DormStudent
      *
      * @return DormStudent
      */
    public function new()
    {
        return new $this->_dorm_student(new $this->_student_class(), new $this->_contact_class());
    }

    /**
      * fetchAll
      *
      * Fetch all active DormStudent records.
      *
      * @return array Array of DormStudents.
      */
    public function fetchAll()
    {
        $students = $this->_student_query::create()
            ->filterByStatus('active')
            ->find();

        if (count($students) < 1) {
            return $students;
        }

        $dorm_students = array();

        foreach ($students as $student) {
            $dorm_student = $this->getDormStudentFromStudent($student);
            array_push($dorm_students, $dorm_student);
        }

        return $dorm_students;
    }

    /**
      * findById
      *
      * Retrieve DormStudent from ID
      *
      * @param string $id ID from Student table to return Student for.
      *
      * @return DormStudent
      */
    public function findById($id)
    {
        $student = $this->_student_query::create()
            ->filterByStatus('active')
            ->findOneById($id);

        if ($student == NULL) {
            return NULL;
        }

        return $this->getDormStudentFromStudent($student);
    }

    /**
      * findByStudentNum
      *
      * Retrieve DormStudent from StudentNum
      *
      * @param string $student_num StudentNum from Student table to return Student for.
      *
      * @return DormStudent
      */
    public function findByStudentNum($student_num)
    {
        $student = $this->_student_query::create()
            ->filterByStatus('active')
            ->findOneByStudentNum($student_num);

        if ($student == NULL) {
            return NULL;
        }

        return $this->getDormStudentFromStudent($student);
    }
}


class DormStudentQueryException extends \Exception {}
