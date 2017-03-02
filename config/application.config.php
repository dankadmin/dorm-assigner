<?php

return array(
    'modules' => array(
        'Application',
        'ImhPropel',
        'ZF\\DevelopmentMode',
        'PipelinePropel'
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor'
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
    ),
);