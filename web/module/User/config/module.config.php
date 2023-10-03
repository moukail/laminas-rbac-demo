<?php

declare(strict_types=1);

namespace User;

use Laminas\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            'user-index' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/users',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'user-profile' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/profile',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'profile',
                    ],
                ],
            ],
            'user-register' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/register',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'register',
                    ],
                ],
            ],
            'register-success' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/register/success',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'success',
                    ],
                ],
            ],
            'user-view' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/users/view/:id',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'view',
                    ],
                ],
            ],
            'user-edit' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/user/edit/:id',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'edit',
                    ],
                    'constraints' => [
                        'id' => '\d+', // Allow only numeric values for the 'id' parameter
                    ],
                ],
            ],
            'user-delete' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/user/delete/:id',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'delete',
                    ],
                    'constraints' => [
                        'id' => '\d+', // Allow only numeric values for the 'id' parameter
                    ],
                ],
            ],
            'role-index' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/roles',
                    'defaults' => [
                        'controller' => Controller\RoleController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'role-add' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/role/add',
                    'defaults' => [
                        'controller' => Controller\RoleController::class,
                        'action' => 'add',
                    ],
                ],
            ],
            'role-edit' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/role/edit/:id',
                    'defaults' => [
                        'controller' => Controller\RoleController::class,
                        'action' => 'edit',
                    ],
                    'constraints' => [
                        'id' => '\d+', // Allow only numeric values for the 'id' parameter
                    ],
                ],
            ],
            'role-delete' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/role/delete/:id',
                    'defaults' => [
                        'controller' => Controller\RoleController::class,
                        'action' => 'delete',
                    ],
                    'constraints' => [
                        'id' => '\d+', // Allow only numeric values for the 'id' parameter
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\UserController::class => Factory\UserControllerFactory::class,
            Controller\RoleController::class => Factory\RoleControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'user/index/index' => __DIR__ . '/../view/user/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];