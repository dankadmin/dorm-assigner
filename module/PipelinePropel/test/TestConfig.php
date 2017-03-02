<?php
return array(
    'modules' => array(
        'PipelinePropel'
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            '../../../config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            'module',
            'vendor'
        )
    ),
    'propel' => array(
        'database' => array(
            'connections' => array(
                'customer_tracking' => array(
                    'dsn' => 'sqlite:' . __DIR__ . '/data/customer_tracking.db'
                )
            )
        )
    )
);