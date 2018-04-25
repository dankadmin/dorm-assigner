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

use Application\Classes\DormRoomException;
use PipelinePropel\Room;
use PipelinePropel\RoomQuery;
use PipelinePropel\RoomAssignment;
use PipelinePropel\RoomAssignmentQuery;
use Application\Classes\Model\DormStudent;
use PipelinePropel\Student;


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
    /** CONSTANTS **/

    /** @var int ROOM_SLOTS Number of students which may occupy a single room */
    const ROOM_SLOTS = 2;

    /** PROPERTIES **/

    /** @var array $_assignments Array of active room RoomAssignments. */
    private $_assignments;

    /** @var string $_name Dorm room name. */
    private $_name;

    /** @var string $_gender Gender of occupied room. May be 'male', 'female', or NULL. */
    private $_gender;

    /** @var Room $_room Dorm room. */
    private $_room;

    /**
      * Constructor
      *
      * @param Room $room
      */
    public function __construct(Room $room)
    {
        $this->_room = $room;
        $this->addAssignmentsForRoom();
    }

    /**
      * setRoomGender
      *
      * Set the room's gender based upon the gender of the containing unit.
      */
    private function setRoomGender()
    {
        $this->_gender = NULL;

        $unit = $this->_room->getUnit();
        $rooms = RoomQuery::create()
            ->filterByUnit($unit)
            ->find();

        $assignments = RoomAssignmentQuery::create()
            ->filterByStatus('active')
            ->filterByRoom($rooms)
            ->find();

        if (count($assignments) > 0) {
            $student = $assignments[0]->getStudent();
            $this->_gender = $student->getGender();
        }
    }

    /**
      * addAssignmentsForRoom
      *
      * Search forroom assignments for this room and adds them to the class.
      */
    private function addAssignmentsForRoom()
    {

        $this->_assignments = array();
        $this->setRoomGender();

        $room_assignments = RoomAssignmentQuery::create()
            ->filterByRoom($this->_room)
            ->filterByStatus('active')
            ->find();

        foreach ($room_assignments as $assignment) {
            $this->addAssignment($assignment);
        }
    }

    /**
      * addAssignment
      *
      * Add a new assignment to this room if there are available slots and set
      * the rest to inactive.
      *
      * @param RoomAssignment $assignment
      *
      * @return bool
      */
    private function addAssignment($assignment)
    {
        if (count($this->_assignments) > self::ROOM_SLOTS) {
            $assignment->setStatus('inactive');
            $assignment->save();
            return false;
        } else {
            $student = $assignment->getStudent();
            $this->_gender = $student->getGender();

            array_push($this->_assignments, $assignment);
            return true;
        }
    }

    /**
      * assignStudent
      *
      * Assign a Student to this room, removing any previous student assignments.
      *
      * @param Student $dorm_student
      *
      * @throws DormRoomException if the room is full or if the gender is not acceptable.
      *
      * @return bool
      */
    public function assignStudent(Student $student)
    {
        if (count($this->_assignments) >= self::ROOM_SLOTS) {
            throw new DormRoomException(
                "Attempt to assign student to full dorm room",
                1
            );
        }

        $gender = $student->getGender();

        if ($this->_gender != NULL) {
            if ($this->_gender != $gender) {
                throw new DormRoomException(
                    "Attempt to assign '$gender' student to a {$this->_gender} dorm room",
                    2
                );
            }

        }

        $this->removeStudentAssignments($student);

        $assignment = new RoomAssignment();
        $assignment->setRoom($this->_room);
        $assignment->setStudent($student);
        $assignment->setStatus('active');
        $assignment->save();

        return $this->addAssignment($assignment);
    }

    /**
      * assignDormStudent
      *
      * Assign a DormStudent to this room.
      *
      * @param DormStudent $dorm_student
      *
      * @return bool
      */
    public function assignDormStudent(DormStudent $dorm_student)
    {
        $student = $dorm_student->getStudent();

        return $this->assignStudent($student);
    }

    /**
      * removeStudentAssignments
      *
      * Searching for active assignments for student and sets them to inactive.
      *
      * @param Student $student Student to remove assignments for.
      */
    private function removeStudentAssignments(Student $student)
    {
        $assignments = RoomAssignmentQuery::create()
            ->filterByStudent($student)
            ->filterByStatus('active')
            ->find();

        foreach ($assignments as $assignment) {
            $assignment->setStatus('inactive');
            $assignment->save();
        }
    }

    /**
      * unassignDormStudent
      *
      * Unassign student from room
      *
      * @param DormStudent $dorm_student Dorm student to remove assignments for.
      */
    public function unassignDormStudent(DormStudent $dorm_student)
    {
        $student = $dorm_student->getStudent();

        return $this->unassignStudent($student);
    }

    /**
      * unassignStudent
      *
      * Unassign student from room
      *
      * @param Student $student Student to remove assignments for.
      */
    public function unassignStudent(Student $student)
    {
        foreach ($this->_assignments as $assignment) {
            if ($assignment->getStudent() == $student) {
                $assignment->setStatus('inactive');
                $assignment->save();
                return true;
            }
        }

        if (count($this->_assignments) < 1) {
            $this->setRoomGender();
        }
    }

    /**
      * getRoom
      *
      * Return the room model.
      *
      * @returns Room
      */
    public function getRoom()
    {
        return $this->_room;
    }

    /**
      * getStudents
      *
      * Return an array of students assigned to room
      *
      * @returns array Array of Student models
      */
    public function getStudents()
    {
        $students = array();

        foreach ($this->_assignments as $assignment) {
            array_push($students, $assignment->getStudent());
        }

        return $students;
    }

    /**
      * getGender
      *
      * Return the gender assigned to this room.
      *
      * @returns string Gender, either 'male', 'female', or NULL
      */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
      * getRoomName
      *
      * Returns a string unique to this room
      *
      * @returns string Room Name
      */
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
