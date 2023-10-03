<?php

use Application\Command\DoctrineFixturesLoadCommand;

return [
    'doctrine' => [
        'connection' => [
            // default connection name
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDO\MySQL\Driver::class,
                'params' => [
                    'host'     => getenv('DATABASE_HOST'),
                    'port'     => getenv('DATABASE_PORT'),
                    'user'     => getenv('DATABASE_USER'),
                    'password' => getenv('DATABASE_PASSWORD'),
                    'dbname'   => getenv('DATABASE_NAME'),
                ],
            ],
        ],
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'application_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AttributeDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../../module/Application/src/Entity',
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'Application\Entity' => 'application_driver',
                ],
            ],
        ],
        'migrations_configuration' => [
            'orm_default' => [
                'table_storage' => [
                    'table_name' => 'migration_versions',
                    'version_column_name' => 'version',
                    'version_column_length' => 191,
                    'executed_at_column_name' => 'executedAt',
                    'execution_time_column_name' => 'executionTime',
                ],
                'migrations_paths' => [
                    'Application' => __DIR__ . '/../../migrations',
                ], // an array of namespace => path
                'migrations' => [
                //    'Application\Migrations',
                ], // an array of fully qualified migrations
                'all_or_nothing' => false,
                'check_database_platform' => true,
                //'organize_migrations' => 'year', // year or year_and_month
                'custom_template' => null,
            ],
        ],
        'authentication' => [
            'orm_default' => [
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Application\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => 'Application\Entity\User::verifyHashedPassword'
            ],
        ],
    ]
];
