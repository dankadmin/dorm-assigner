<?php
return array(
    'propel' => array(
        'paths' => array(
            'schema'     => __DIR__,
            'migrations' => __DIR__ . '/../data/migrations',
            'class'      => __DIR__ . '/../src'
        ),
        'database' => array(
            'connections' => array(
                'timr_dorm' => array()
            )
        ),
        'runtime' => array(
            'defaultConnection' => 'timr_dorm',
            'connections'       => array(
                'timr_dorm'
            )
        ),
        'generator' => array(
            'defaultConnection' => 'timr_dorm',
            'connections' => array(
                'timr_dorm'
            )
        )
    )
);
