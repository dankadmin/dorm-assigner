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
                'jasonb_dorm' => array()
            )
        ),
        'runtime' => array(
            'defaultConnection' => 'jasonb_dorm',
            'connections'       => array(
                'jasonb_dorm'
            )
        ),
        'generator' => array(
            'defaultConnection' => 'jasonb_dorm',
            'connections' => array(
                'jasonb_dorm'
            )
        )
    )
);