<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1493224431.
 * Generated on 2017-04-26 12:33:51 by timr
 */
class PropelMigration_1493224431
{
    public $comment = '';

    public function preUp($manager)
    {
        // add the pre-migration code here
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

CREATE TABLE `student`
(
    `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `gender` TINYINT NOT NULL,
    `student_num` VARCHAR(8) NOT NULL,
    `birth_date` DATE NOT NULL,
    `status` TINYINT DEFAULT 1,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `student_num_in3` (`student_num`),
    INDEX `gender_in1` (`gender`),
    INDEX `status_in2` (`status`)
) ENGINE=InnoDB;

CREATE TABLE `contact_info`
(
    `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
    `student_id` INTEGER(11) NOT NULL,
    `phone_number` CHAR(11) NOT NULL,
    `address_1` VARCHAR(255) NOT NULL,
    `address_2` VARCHAR(255),
    `city` VARCHAR(255) NOT NULL,
    `state` CHAR(2) NOT NULL,
    `zip` CHAR(5) NOT NULL,
    `status` TINYINT DEFAULT 1,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `student_id_in4` (`student_id`),
    INDEX `state_in5` (`state`),
    INDEX `zip_in6` (`zip`),
    INDEX `status_in7` (`status`),
    CONSTRAINT `student_id_fk1`
        FOREIGN KEY (`student_id`)
        REFERENCES `student` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `dorm`
(
    `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `floor`
(
    `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
    `dorm_id` INTEGER(11) NOT NULL,
    `number` TINYINT(1) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `dorm_id_in8` (`dorm_id`),
    CONSTRAINT `dorm_id_fk2`
        FOREIGN KEY (`dorm_id`)
        REFERENCES `dorm` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `unit`
(
    `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
    `floor_id` INTEGER(11) NOT NULL,
    `number` TINYINT(1) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `floor_id_in9` (`floor_id`),
    CONSTRAINT `floor_id_fk3`
        FOREIGN KEY (`floor_id`)
        REFERENCES `floor` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `room`
(
    `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
    `unit_id` INTEGER(11) NOT NULL,
    `number` TINYINT(1) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `unit_id_in10` (`unit_id`),
    CONSTRAINT `unit_id_fk4`
        FOREIGN KEY (`unit_id`)
        REFERENCES `unit` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `room_assignment`
(
    `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
    `student_id` INTEGER(11) NOT NULL,
    `room_id` INTEGER(11) NOT NULL,
    `status` TINYINT DEFAULT 1,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `student_id_in11` (`student_id`),
    INDEX `room_id_in12` (`room_id`),
    INDEX `status_in13` (`status`),
    CONSTRAINT `student_id_fk5`
        FOREIGN KEY (`student_id`)
        REFERENCES `student` (`id`),
    CONSTRAINT `room_id_fk6`
        FOREIGN KEY (`room_id`)
        REFERENCES `room` (`id`)
) ENGINE=InnoDB;

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

DROP TABLE IF EXISTS `student`;

DROP TABLE IF EXISTS `contact_info`;

DROP TABLE IF EXISTS `dorm`;

DROP TABLE IF EXISTS `floor`;

DROP TABLE IF EXISTS `unit`;

DROP TABLE IF EXISTS `room`;

DROP TABLE IF EXISTS `room_assignment`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}