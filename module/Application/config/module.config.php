<?php

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'students' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/student',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Student',
                        'action'     => 'index',
                    ),
                ),
            ),
            'addStudent' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/student/add',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Student',
                        'action'     => 'add',
                    ),
                ),
            ),
            'editStudent' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/student/edit/:studentId',
                    'constraints' => array(
                        'studentId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Student',
                        'action'     => 'edit',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application/Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Student' => 'Application\Controller\StudentController',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'bootstrapForm' => 'Application\View\Helper\BootstrapForm',
            'uppercase' => 'MyModule\View\Helper\UpperCase',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                'Application' => __DIR__ . '/public',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Home',
                'route' => 'home',
            ),
            array(
                'label' => 'Students',
                'route' => 'students',
                'pages' => array(
                    array(
                        'label' => 'Add Student',
                        'route' => 'addStudent',
                    ),
                ),
            ),
        ),
    ),
);
