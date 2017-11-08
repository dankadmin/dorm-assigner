<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1499278176.
 * Generated on 2017-07-05 14:09:36 by timr
 */
class PropelMigration_1499278176
{
    public $comment = '';

    public function preUp($manager)
 {
          \ImhPropel\Propel\Generator\MigrationBootstrap::init($manager, "PipelinePropel");

        $dorms = array('A','B','C','D','E','F');

        $floors = array(1,2,3);

        $units = array(1,2,3,4);

        $rooms = array(1,2,3,4);

        foreach ($dorms as $dorm_name) {
            $dorm = new \PipelinePropel\Dorm();
            $dorm->setName($dorm_name)
                ->save();

            foreach ($floors as $floor_number) {
                $floor = new \PipelinePropel\Floor();
                $floor->setDormId($dorm->getId())
                    ->setNumber($floor_number)
                    ->save();

                foreach ($units as $unit_number) {
                    $unit = new \PipelinePropel\Unit();
                    $unit->setFloorId($floor->getId())
                         ->setNumber($unit_number)
                         ->save();
    
                    foreach ($rooms as $room_number) {
                        $room = new \PipelinePropel\Room();
                        $room->setUnitId($unit->getId())
                             ->setNumber($room_number)
                             ->save();
                    }

                }
            }

        }
 
    }

    public function postUp($manager)
    {
        // add the post-migration code here
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {

        return array (
  'timr_dorm' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE `room`;
TRUNCATE `unit`;
TRUNCATE `floor`;
TRUNCATE `dorm`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'timr_dorm' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}
