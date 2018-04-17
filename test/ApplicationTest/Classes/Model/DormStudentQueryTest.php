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
    private $_test_student_id;

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

        $this->_test_student_id = 'JD112233';

        $data = array(
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address_1' => '123 Main Street',
            'city' => 'Someplace',
            'state' => 'MO',
            'zip' => '12345',
            'gender' => 'male',
            'student_num' => $this->_test_student_id,
            'birth_date' => '1970-01-01',
            'phone_number' => '7575551234',
            'status' => 'active',
        );


        $new_student = $this->_student_query->newStudent();
        $new_student->exchangeArray($data);
        $new_student->save();
    }

    /** 
      * tearDown
      *
      * Tear Down tests
      */
    public function tearDown()
    {
        $new_student = $this->_student_query->findByStudentNum($this->_test_student_id);
        $new_student->hardDelete();
    }

    /** 
      * testDormStudentQueryCanCreateNewStudent
      *
      */
    public function testDormStudentQueryCanCreateNewStudent()
    {
        $student = $this->_student_query->newStudent();
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

        $this->assertTrue(count($students) > 0);

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
