<?php
return array(
    'propel' => array(
        'data_directory' => 'data/propel',
        'database' => array(
            'connections' => array(
                'default' => array(
                    'adapter' => 'mysql',
                    'classname' => 'Propel\\Runtime\\Connection\\ConnectionWrapper',
                    'settings' => array(
                        'charset' => 'utf8',
                        'queries' => array(
                            'utf8' => 'SET NAMES utf8 COLLATE utf8_unicode_ci, COLLATION_CONNECTION = utf8_unicode_ci, COLLATION_DATABASE = utf8_unicode_ci, COLLATION_SERVER = utf8_unicode_ci',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
