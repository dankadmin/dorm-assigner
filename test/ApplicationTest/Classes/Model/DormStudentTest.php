<?php
/**
  * DormStudentTest Source Code
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
  * DormStudent Test classs
  *
  * Test the DormStudent model
  *
  * @category DormAssigner
  * @package DormAssigner\ApplicationTest\Classes\Model
  * @subpackage DormStudentTest
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class DormStudentTest extends AbstractHttpControllerTestCase
{
    private $_student_query;
    private $_student;

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

        $this->_student = $this->_student_query->new();
    }

    /** 
      * setUp
      *
      * Set up tests
      */
    public function tearDown()
    {
        $this->_student->hardDelete();
    }

    /** 
      * testDormStudentCanAddDataFromArray
      *
      */
    public function testDormStudentCanAddDataFromArray()
    {
        $data = array(
            'id' => '',
            'first_name' => 'John III',
            'last_name' => 'Doe',
            'address_1' => '123 Main Street',
            'city' => 'Someplace',
            'state' => 'Alabama',
            'zip' => '12345',
            'gender' => 'male',
            'student_num' => 'JD123459',
            'birth_date' => '1970-01-01',
            'phone_number' => '7575551234',
            'status' => 'active',
        );

        $this->_student->exchangeArray($data);

        $this->assertSame('John III Doe', $this->_student->getFullName());
    }

    /** 
      * testDormStudentCanSaveRetrieveAndRemoveData
      *
      */
    public function testDormStudentCanSaveRetrieveAndRemoveData()
    {
        $number = 'JD123459';
        $data = array(
            'id' => '',
            'first_name' => 'John III',
            'last_name' => 'Doe',
            'address_1' => '123 Main Street',
            'city' => 'Someplace',
            'state' => 'Alabama',
            'zip' => '12345',
            'gender' => 'male',
            'student_num' => $number,
            'birth_date' => '1970-01-01',
            'phone_number' => '7575551234',
            'status' => 'active',
        );

        $new_student = $this->_student_query->new();

        $new_student->exchangeArray($data);

        $this->assertSame($number, $new_student->getStudentNum());

        $new_student->save();

        $this->assertTrue($this->_student_query->findByStudentNum($number) instanceof \Application\Classes\Model\DormStudent);

        $new_student->hardDelete();

        $this->assertSame($this->_student_query->findByStudentNum($number), NULL);
    }

    /** 
      * 
      *
      */
    public function testDormStudent()
    {
        $data = array(
            'id' => '',
            'first_name' => 'John III',
            'last_name' => 'Doe',
            'address_1' => '123 Main Street',
            'city' => 'Someplace',
            'state' => 'Alabama',
            'zip' => '12345',
            'gender' => 'male',
            'student_num' => 'JD123459',
            'birth_date' => '1970-01-01',
            'phone_number' => '7575551234',
            'status' => 'active',
        );

        $this->_student->exchangeArray($data);

        $this->_student->save();

        $duplicate_student = $this->_student_query->new();

        $duplicate_student->exchangeArray($data);

        $this->expectException('Propel\Runtime\Exception\PropelException');

        $duplicate_student->save();
    }

}
