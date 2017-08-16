<?php

namespace PipelinePropel;

use PipelinePropel\Base\RoomQuery as BaseRoomQuery;
use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Skeleton subclass for performing query and update operations on the 'room' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class RoomQuery extends BaseRoomQuery
{

    const STUDENT_LIMIT = 2;

    public static function findAvailableRoomsByGender($gender) {
        $room_ids = array();

        $rooms = self::create()->find();
        foreach ($rooms as $room) {
            $occupants = \PipelinePropel\RoomAssignmentQuery::create()
                ->filterByRoomId($room->getId())
                ->filterByStatus('active')
                ->count();

            if ($occupants >= self::STUDENT_LIMIT) {
                continue;
            }
            if (!$room->getUnit()->isGenderPermitted($gender)) {
                continue;
            }
            $room_ids[] = $room->getId(); 
        }

        return self::create()->filterById($room_ids)->find();
    }

}
