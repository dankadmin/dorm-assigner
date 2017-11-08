<?php

namespace PipelinePropel;

use PipelinePropel\Base\RoomAssignment as BaseRoomAssignment;

/**
 * Skeleton subclass for representing a row from the 'room_assignment' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class RoomAssignment extends BaseRoomAssignment
{

    const STUDENT_LIMIT = 2;

    public function validateGender() {

        $student = $this->getStudent();

        $gender = $student->getGender();

        $unit = $this->getRoom()->getUnit();

        if (!$unit->isGenderPermitted($gender)) {
            throw new \Exception('There is already a student of the opposite gender in that unit');
        }
    }

    public function validateOccupantCount() {
        $roomAssignments =   \PipelinePropel\RoomAssignmentQuery::create()
            ->filterByRoomId($this->getRoom()->getId())
            ->filterByStatus('active')
            ->count();

        if ($roomAssignments >= \PipelinePropel\RoomQuery::STUDENT_LIMIT ) {
            throw new \Exception('There are already ' . \PipelinePropel\RoomQuery::STUDENT_LIMIT . ' students assigned to this dorm');
        }

    }

    public function preSave() {
        $this->validateGender();
        $this->validateOccupantCount();
        return true;
    }

}
