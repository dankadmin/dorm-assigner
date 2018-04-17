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
    private $_student_data;

    private $_student_1;
    private $_student_2;
    private $_student_3;

    private $_room_1;
    private $_room_2;

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


        $this->_dorm_query = new DormRoomQuery();

    }

    /** 
      * testDormRoomQueryCanCreateNewRoom
      *
      */
    public function testDormRoomQueryCanCreateNewRoom()
    {
        //$student = $this->_dorm_query->new();
        //$this->assertTrue($student instanceof \Application\Classes\DormRoom);

        $ass = new \PipelinePropel\RoomAssignment();
        $room = \PipelinePropel\RoomQuery::create()->findPk(265);
        $student = \PipelinePropel\StudentQuery::create()->findPk(7);
        $ass->setRoom($room);
        $ass->setStudent($student);
        //$ass->save();
        //$dorm = new \Application\Classes\DormRoom($ass);

        $dorm_query = new \Application\Classes\DormRoomQuery();

        $test = $dorm_query->findByRoomId(8);

        $test->assignStudent($student);

        $room2 = \PipelinePropel\RoomQuery::create()->findPk(175);

        $test2 = $dorm_query->findByRoom($room2);
        $test2->assignStudent($student);

        /*
        echo "Gender: " . $dorm_query->findGender($room2) . "\n";

        foreach ($dorm_query->findUnoccupied("female") as $room) {
            echo $room->getRoomName() . "\n";
        }

        var_dump($test2->getRoomName());
        */

        $this->assertEquals($dorm_query->findGender($room2), "male");
    }

}
