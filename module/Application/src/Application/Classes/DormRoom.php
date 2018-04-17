<?php
/**
  * Dorm Room Source Code
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Classes\Model
  * @subpackage DormRoom
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace Application\Classes;


/**
  * Dorm Room
  *
  * Room information
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Classes\Model
  * @subpackage DormRoom
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class DormRoom
{

    private $_assignment;

    /** @var string $_name Dorm room name. */
    private $_name;

    /** @var string $_assigned Whether room is occuped. May be 'unoccupied', 'partial', or 'full'. */
    private $_assigned;

    /** @var string $_gender Gender of occupied room. May be 'male', 'female', or 'unoccupied'. */
    private $_gender;

    /** @var \PipelinePropel\Room $_room. */
    private $_room;
    private $_student;

    /**
      * Constructor
      *
      */
    public function __construct(\PipelinePropel\RoomAssignment $assignment)
    {
        $this->_assignment = $assignment;
        $this->_room = $this->_assignment->getRoom();
        $this->_student = $this->_assignment->getStudent();
        //$this->_gender = $this->findGender();
    }

    private function disableCurrentAssignments()
    {
        if (!$this->_assignment->isNew()) {
            $this->_assignment->setStatus('inactive');
            $this->_assignment->save();
        }

        if ($this->_student != NULL) {
            $assignments = \PipelinePropel\RoomAssignmentQuery::create()
                ->filterByStudent($this->_student)
                ->filterByStatus('active')
                ->find();

            foreach ($assignments as $assignment) {
                $assignment->setStatus('inactive');
                $assignment->save();
            }
        }

        if ($this->_room != NULL) {
            $assignments = \PipelinePropel\RoomAssignmentQuery::create()
                ->filterByRoom($this->_room)
                ->filterByStatus('active')
                ->find();

            foreach ($assignments as $assignment) {
                $assignment->setStatus('inactive');
                $assignment->save();
            }
        }

        $this->_assignment = new \PipelinePropel\RoomAssignment();
    }

    /**
      * assignStudent
      *
      */
    public function assignStudent($student)
    {
        $this->disableCurrentAssignments();
        $this->_student = $student;
        $this->_assignment->setRoom($this->_room);
        $this->_assignment->setStudent($student);
        $this->_assignment->save();
        //$this->_gender = $this->findGender();
    }

    public function unassignStudent()
    {
        $this->disableCurrentAssignments();
    }

    public function getRoom()
    {
        return $this->_room;
    }

    public function getStudent()
    {
        return $this->_student;
    }

    public function getGender()
    {
        if ($this->_student == NULL) {
            return NULL;
        }

        return $this->_student->getGender();
    }

    public function getRoomName()
    {
        $room_name = $this->_room->getName();

        $unit = $this->_room->getUnit();
        $unit_name = $unit->getName();

        $floor = $unit->getFloor();
        $floor_name = $floor->getName();

        $dorm_name = $floor->getDorm()->getName();

        return "$dorm_name-$floor_name-$unit_name-$room_name";
    }

}
