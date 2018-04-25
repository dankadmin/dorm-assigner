<?php
/**
  * Dorm Room Query Source Code
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Classes\Model
  * @subpackage DormRoomQuery
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace Application\Classes;


/**
  * Dorm Room Query
  *
  * Room information
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Classes\Model
  * @subpackage DormRoomQuery
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class DormRoomQuery
{
    public function findByRoomId($id)
    {
        $room = \PipelinePropel\RoomQuery::create()->findPk($id);

        return $this->findByRoom($room);
    }

    public function findByRoom($room)
    {
        if ($room == NULL) {
            return NULL;
        }

        $dorm_room = new \Application\Classes\DormRoom($room);
        return $dorm_room;
    }

    public function findByStudent($student)
    {
        if ($student == NULL) {
            return NULL;
        }

        $assignment = \PipelinePropel\RoomAssignmentQuery::create()
            ->filterByStudent($student)
            ->filterByStatus('active')
            ->findOne();


        if ($assignment != NULL) {
            $room = $assignment->getRoom();
            $dorm_room = new \Application\Classes\DormRoom($room);
            return $dorm_room;
        }

        return NULL;
    }

    public function findUnoccupied($gender=NULL)
    {
        $room_list = array();

        $rooms = \PipelinePropel\RoomQuery::create()->find();

        foreach ($rooms as $room) {
            $dorm_room = $this->findByRoom($room);
            if ($dorm_room == NULL || $dorm_room->isFull()) {
                continue;
            }

            if ($dorm_room->getGender() == NULL) {
                array_push($room_list, $dorm_room);
            } else {
                if ($dorm_room->getGender() == $gender) {
                    array_push($room_list, $dorm_room);
                }
            }
        }

        return $room_list;
    }

    public function findGender($this_room)
    {
        $unit = $this_room->getUnit();

        $rooms = \PipelinePropel\RoomQuery::create()
            ->filterByUnit($unit)
            ->find();

        foreach ($rooms as $room) {
            $assignment = \PipelinePropel\RoomAssignmentQuery::create()
                ->filterByRoom($room)
                ->filterByStatus('active')
                ->findOne();

            if ($assignment == NULL) {
                continue;
            }

            $student = $assignment->getStudent();
            return $student->getGender();
        }

        return "unoccupied";

    }

    /**
      * Constructor
      *
      * Set the list of available states.
      *
      */
    //public function __construct(\PipelinePropel\Student $student_model, \PipelinePropel\ContactInfo $contact_info_model)
    public function __construct()
    {
        //$this->_student = $student_model;
        //$this->_contact = $contact_info_model;
    }

}
