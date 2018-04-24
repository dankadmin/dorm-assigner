<?php
/**
  * DormRoomQueryTest Source Code
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

use Application\Classes\Model\DormStudentQuery;
use Application\Classes\DormRoomQuery;

/**
  * DormRoomQuery Test classs
  *
  * Test the DormRoom model
  *
  * @category DormAssigner
  * @package DormAssigner\ApplicationTest
  * @subpackage DormRoomQueryTest
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class DormRoomQueryTest extends AbstractHttpControllerTestCase
{
    private $_faker;
    private $_dorm_query;
    private $_student_query;
    private $_student_data;

    private $_student_1;
    private $_student_2;

    private $_room_1;
    private $_room_2;

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

        $this->_student_query = new DormStudentQuery();


        $this->_dorm_query = new DormRoomQuery();

        $this->_student_1 = $this->_student_query->newStudent();
        $this->_student_1->exchangeArray($this->_student_data->create());
        $this->_student_1->save();

        $this->_student_2 = $this->_student_query->newStudent();
        $this->_student_2->exchangeArray($this->_student_data->create());
        $this->_student_2->save();

        $this->_room_1 = \PipelinePropel\RoomQuery::create()->findPk(rand(1,288));
        $this->_room_2 = \PipelinePropel\RoomQuery::create()->findPk(rand(1,288));

        $this->_assignment_1 = new \PipelinePropel\RoomAssignment();
        $this->_assignment_1->setRoom($this->_room_1);
        $this->_assignment_1->setStudent(
            \PipelinePropel\StudentQuery::create()->findPk(
                $this->_student_1->getId()
            )
        );
        $this->_assignment_1->save();

        $this->_assignment_2 = new \PipelinePropel\RoomAssignment();
    }

    /** 
      * tearDown
      *
      * Tear down tests
      */
    public function tearDown()
    {
        $this->_assignment_1->delete();
        $this->_assignment_2->delete();

        $this->_student_1->hardDelete();
        $this->_student_2->hardDelete();
    }

    /** 
      * testDormRoomQueryCanFindARoomByRoom
      *
      */
    public function testDormRoomQueryCanFindARoomByRoom()
    {
        $this->assertNotNull($this->_dorm_query->findByRoom($this->_room_1));
    }

    /** 
      * testDormRoomQueryCanFindARoomById
      *
      */
    public function testDormRoomQueryCanFindARoomById()
    {
        $room_id = $this->_room_1->getId();
        $this->assertNotNull($this->_dorm_query->findByRoomId($room_id));
    }

    /** 
      * testDormRoomQueryGivesNullOnFindNonExistantRoomById
      *
      */
    public function testDormRoomQueryGivesNullOnFindNonExistantRoomById()
    {
        $this->assertNull($this->_dorm_query->findByRoomId(5000));
    }

    /** 
      * testDormRoomQueryCanFindARoomByStudent
      *
      */
    public function testDormRoomQueryCanFindARoomByStudent()
    {
        $student = \PipelinePropel\StudentQuery::create()->findPk(
            $this->_student_1->getId()
        );

        $this->assertNotNull($this->_dorm_query->findByStudent($student));
    }

    /** 
      * testDormRoomQueryCanFindUnoccupiedRooms
      *
      */
    public function testDormRoomQueryCanFindUnoccupiedRooms()
    {
        $this->assertNotNull($this->_dorm_query->findUnoccupied());
    }

    /** 
      * testDormRoomQueryCanFindUnoccupiedRoomsForMales
      *
      */
    public function testDormRoomQueryCanFindUnoccupiedRoomsForMales()
    {
        $this->assertNotNull($this->_dorm_query->findUnoccupied("male"));
    }

    /** 
      * testDormRoomQueryCanFindUnoccupiedRoomsForFemales
      *
      */
    public function testDormRoomQueryCanFindUnoccupiedRoomsForFemales()
    {
        $this->assertNotNull($this->_dorm_query->findUnoccupied("female"));
    }

}
