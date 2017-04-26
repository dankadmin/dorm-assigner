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
                'pipeline' => array()
            )
        ),
        'runtime' => array(
            'defaultConnection' => 'pipeline',
            'connections'       => array(
                'pipeline'
            )
        ),
        'generator' => array(
            'defaultConnection' => 'pipeline',
            'connections' => array(
                'pipeline'
            )
        )
    )
);