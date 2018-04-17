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

        $assignment = \PipelinePropel\RoomAssignmentQuery::create()
            ->filterByRoom($room)
            ->filterByStatus('active')
            ->findOne();

        if ($assignment != NULL) {
            $dorm_room = new \Application\Classes\DormRoom($assignment);
            return $dorm_room;
        }

        $assignment = new \PipelinePropel\RoomAssignment();
        $assignment->setRoom($room);

        $dorm_room = new \Application\Classes\DormRoom($assignment);
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
            $dorm_room = new \Application\Classes\DormRoom($assignment);
            return $dorm_room;
        }

        return NULL;
    }

    public function findUnoccupied($gender="")
    {
        $room_list = array();

        $rooms = \PipelinePropel\RoomQuery::create()->find();

        foreach ($rooms as $room) {
            $dorm_room = $this->findByRoom($room);
            if ($dorm_room == NULL) {
                next;
            }

            if ($dorm_room->getStudent() == NULL) {
                if ( $gender == "") {
                    array_push($room_list, $dorm_room);
                } else {
                    $occupied = $this->findGender($room);
                    if ($occupied == "unoccupied" || $occupied == $gender) {
                        echo "[$occupied]\n";
                        array_push($room_list, $dorm_room);
                    } else {
                        echo "[$occupied]\n";
                    }
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