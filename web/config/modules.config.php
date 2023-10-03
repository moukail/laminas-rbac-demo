<?php

/**
 * List of enabled modules for this application.
 *
 * This should be an array of module namespaces used in the application.
 */
return [
    'Laminas\Mvc\Plugin\FlashMessenger',
    'Laminas\I18n',
    'Laminas\Cache',
    'Laminas\Form',
    'Laminas\Hydrator',
    'Laminas\InputFilter',
    'Laminas\Filter',
    'Laminas\Paginator',
    'Laminas\Session',
    'Laminas\Router',
    'Laminas\Validator',
    'DoctrineModule',
    'Laminas\Cache\Storage\Adapter\Filesystem',
    'Laminas\Cache\Storage\Adapter\Memory',
    'DoctrineORMModule',
    'Laminas\DeveloperTools',
    'Application',
    'Dashboard',
    'Login',
    'User',
];
