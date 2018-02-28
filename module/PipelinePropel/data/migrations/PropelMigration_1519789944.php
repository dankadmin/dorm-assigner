<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1519789944.
 * Generated on 2018-02-28 03:52:24 by pipeline
 */
class PropelMigration_1519789944
{
    public $comment = '';

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
        \ImhPropel\Propel\Generator\MigrationBootstrap::init($manager, "PipelinePropel");

        $dorm_names = array(
            "A",
            "B",
            "C",
            "D",
            "E",
            "F",
        );

        $floors_per_dorm = 3;
        $units_per_floor = 4;
        $rooms_per_unit = 4;

        foreach ($dorm_names as $name) {
            $dorm = new \PipelinePropel\Dorm();
            $dorm->setName($name)
                 ->save();

            for ($floor_num = 1; $floor_num <= $floors_per_dorm; $floor_num++) {
                $floor = new \PipelinePropel\Floor();

                $floor->setNumber($floor_num)
                     ->setName($floor_num)
                     ->setDormId($dorm->getId())
                     ->save();

                for ($unit_num = 1; $unit_num <= $units_per_floor; $unit_num++) {
                    $unit = new \PipelinePropel\Unit();

                    $unit->setNumber($unit_num)
                         ->setName($unit_num)
                         ->setFloorId($floor->getId())
                         ->save();

                    for ($room_num = 1; $room_num <= $rooms_per_unit; $room_num++) {
                        $room = new \PipelinePropel\Room();
                        $room->setNumber($room_num)
                             ->setName($room_num)
                             ->setUnitId($unit->getId())
                             ->save();
                    }
                }
            }

        }

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
  'pipeline' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

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
  'pipeline' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE `dorm`;
TRUNCATE `floor`;
TRUNCATE `unit`;
TRUNCATE `room`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}
