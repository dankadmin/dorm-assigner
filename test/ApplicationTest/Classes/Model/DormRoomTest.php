<?php
/**
  * DormRoomTest Source Code
  *
  * @category DormAssigner
  * @package DormAssigner\ApplicationTest\Classes
  * @subpackage DormRoomTest
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace ApplicationTest\Classes;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

use Application\Classes\Model\DormStudent;
use Application\Classes\DormRoom;

/**
  * DormRoom Test classs
  *
  * Test the DormRoom model
  *
  * @category DormAssigner
  * @package DormAssigner\ApplicationTest
  * @subpackage DormRoomTest
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class DormRoomTest extends AbstractHttpControllerTestCase
{
    private $_faker;
    private $_dorm_query;
    private $_student_query;
    private $_student_data;

    private $_student_1;
    private $_student_2;
    private $_student_3;

    private $_room_1;
    private $_room_2;
    private $_room_3;

    private $_assignment_1;

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

        $this->_faker = \Faker\Factory::create();
        $this->_student_data = new \Test\Factory\StudentDataFactory($this->_faker);

        $this->_student_query = new \Application\Classes\Model\DormStudentQuery();

        $this->_student_1 = $this->_student_query->newStudent();
        $this->_student_1->exchangeArray($this->_student_data->create());
        $this->_student_1->save();

        $this->_student_2 = $this->_student_query->newStudent();
        $this->_student_2->exchangeArray($this->_student_data->create());
        $this->_student_2->save();

        $this->_student_3 = $this->_student_query->newStudent();
        $this->_student_3->exchangeArray($this->_student_data->create());
        $this->_student_3->save();

        $this->_room_1 = \PipelinePropel\RoomQuery::create()->findPk(rand(1,288));
        $this->_room_2 = \PipelinePropel\RoomQuery::create()->findPk(rand(1,288));
        $this->_room_3 = \PipelinePropel\RoomQuery::create()->findPk(rand(1,288));

        $this->_assignment_1 = new \PipelinePropel\RoomAssignment();
        $this->_assignment_1->setRoom($this->_room_1);
        $this->_assignment_1->setStudent(
            \PipelinePropel\StudentQuery::create()->findPk(
                $this->_student_1->getId()
            )
        );
        $this->_assignment_1->save();

        /*
        $this->_dorm_query = new DormRoomQuery();


        $this->_assignment_2 = new \PipelinePropel\RoomAssignment();
        */
    }

    /** 
      * tearDown
      *
      * Tear down tests
      */
    public function tearDown()
    {
        $this->_assignment_1->delete();
        //$this->_assignment_2->delete();

        $this->_student_1->hardDelete();
        $this->_student_2->hardDelete();
        $this->_student_3->hardDelete();
    }

    /** 
      * testCanMakeDormRoomFromRoom
      *
      */
    public function testCanMakeDormRoomFromRoom()
    {
        $dorm_room = new \Application\Classes\DormRoom($this->_room_1);
        $this->assertNotNull($dorm_room);
    }

    /** 
      * testDormRoomCanFindStudentInRoom
      *
      */
    public function testDormRoomCanFindStudentInRoom()
    {
        $dorm_room = new \Application\Classes\DormRoom($this->_room_1);
        $this->assertNotNull($dorm_room);

        $this->assertNotNull($dorm_room->getStudents()[0]);
    }

    /** 
      * testDormRoomCanAssignAndUnassignStudentToARoom
      *
      */
    public function testDormRoomCanAssignAndUnassignStudentToARoom()
    {
        $dorm_room = new \Application\Classes\DormRoom($this->_room_2);
        $this->assertNotNull($dorm_room);

        $this->assertTrue($dorm_room->assignDormStudent($this->_student_2));

        $this->assertTrue($dorm_room->unassignDormStudent($this->_student_2));
    }

    /** 
      * testDormRoomCanGetGender
      *
      */
    public function testDormRoomCanGetStudent()
    {
        $dorm_room = new \Application\Classes\DormRoom($this->_room_2);

        $dorm_room->assignDormStudent($this->_student_1);

        $gender = $this->_student_1->getGender();

        $this->assertSame($gender, $dorm_room->getGender());
    }

    /** 
      * testDormRoomRejectsDifferentGender
      *
      */
    public function testDormRoomRejectsDifferentGender()
    {
        $dorm_room = new \Application\Classes\DormRoom($this->_room_2);

        $dorm_room->assignDormStudent($this->_student_1);

        $gender_1 = $this->_student_1->getGender();

        $gender_2 = ($gender_1 == 'male') ? 'female' : 'male';

        $this->_student_3->getStudent()->setGender($gender_2);

        $this->expectExceptionCode(2);

        $this->assertFalse($dorm_room->assignDormStudent($this->_student_3));

        $dorm_room->unassignDormStudent($this->_student_2);
        $dorm_room->unassignDormStudent($this->_student_3);
    }

    /** 
      * testDormRoomRejectsTooManyAssignments
      *
      */
    public function testDormRoomRejectsTooManyAssignments()
    {
        $dorm_room = new \Application\Classes\DormRoom($this->_room_2);

        $gender = $this->_student_1->getGender();

        $this->_student_2->getStudent()->setGender($gender);
        $this->_student_3->getStudent()->setGender($gender);


        $this->expectExceptionCode(1);

        $dorm_room->assignDormStudent($this->_student_1);
        $dorm_room->assignDormStudent($this->_student_2);
        $dorm_room->assignDormStudent($this->_student_3);


        $dorm_room->unassignDormStudent($this->_student_1);
        $dorm_room->unassignDormStudent($this->_student_2);


    }

    /** 
      * testDormRoomRemovesOldStudentAssignmentOnNewAssignment
      *
      */
    public function testDormRoomRemovesOldStudentAssignmentOnNewAssignment()
    {
        $dorm_room = new \Application\Classes\DormRoom($this->_room_1);

        $the_student = $dorm_room->getStudents()[0];

        $dorm_room = new \Application\Classes\DormRoom($this->_room_3);

        $dorm_room->assignStudent($the_student);

        $dorm_room = new \Application\Classes\DormRoom($this->_room_1);
        $students = $dorm_room->getStudents();

        foreach ($students as $student) {
            $this->assertNotSame($student, $the_student);
        };

    }

    /** 
      * testDormRoomFindsGenderByContainingUnit
      *
      */
    public function testDormRoomFindsGenderByContainingUnit()
    {
        $room_a = \PipelinePropel\RoomQuery::create()->findPk(288);
        $room_b = \PipelinePropel\RoomQuery::create()->findPk(287);

        $gender = $this->_student_1->getGender();

        $dorm_room_a = new \Application\Classes\DormRoom($room_a);
        $dorm_room_b = new \Application\Classes\DormRoom($room_b);

        $this->assertNull($dorm_room_a->getGender());

        $dorm_room_b->assignDormStudent($this->_student_1);

        $dorm_room_c = new \Application\Classes\DormRoom($room_a);
        $this->assertSame($dorm_room_c->getGender(), $gender);

        $dorm_room_b->unassignDormStudent($this->_student_1);
    }
}
