<?php
/**
  * DormStudentQueryTest Source Code
  *
  * @category DormAssigner
  * @package DormAssigner\ApplicationTest\Classes\Model
  * @subpackage DormStudentTest
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace ApplicationTest\Classes\Model;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

use Application\Classes\Model\DormStudentQuery;

/**
  * DormStudentQuery Test classs
  *
  * Test the DormStudent model
  *
  * @category DormAssigner
  * @package DormAssigner\ApplicationTest\Classes\Model
  * @subpackage DormStudentQueryTest
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class DormStudentQueryTest extends AbstractHttpControllerTestCase
{
    private $_student_query;
    private $_dorm_student_mock;

    /** 
      * setUp
      *
      * Set up tests
      */
    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../../../config/application.config.php'
        );
        parent::setUp();

        $this->dispatch('/student/add');

        $this->_student_query = new DormStudentQuery();
    }

    /** 
      * testDormStudentQueryCanCreateNewStudent
      *
      */
    public function testDormStudentQueryCanCreateNewStudent()
    {
        $student = $this->_student_query->new();
        $this->assertTrue($student instanceof \Application\Classes\Model\DormStudent);
    }

    /** 
      * testDormStudentQueryCanFetchArrayOfDormStudents
      *
      */
    public function testDormStudentQueryCanFetchArrayOfDormStudents()
    {
        $students = $this->_student_query->fetchAll();

        $this->assertTrue(is_array($students));
        $this->assertTrue($students[0] instanceof \Application\Classes\Model\DormStudent);
    }

    /** 
      * testDormStudentQueryCanFindStudentById
      *
      */
    public function testDormStudentQueryCanFindStudentById()
    {
        $students = $this->_student_query->fetchAll();

        $student_id = $students[0]->getId();

        $student = $this->_student_query->findById($student_id);

        $this->assertTrue($student instanceof \Application\Classes\Model\DormStudent);

    }

    /** 
      * testDormStudentQueryCanFindStudentByStudentNum
      *
      */
    public function testDormStudentQueryCanFindStudentByStudentNum()
    {
        $students = $this->_student_query->fetchAll();

        $student_num = $students[0]->getStudentNum();

        $student = $this->_student_query->findByStudentNum($student_num);

        $this->assertTrue($student instanceof \Application\Classes\Model\DormStudent);
    }
}
