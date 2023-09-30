<?php

namespace Dashboard\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Login\MyRbac;
use Psr\Container\ContainerInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authenticationService = $container->get('doctrine.authenticationservice.orm_default');
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new $requestedName($authenticationService, new MyRbac($entityManager));
    }
}