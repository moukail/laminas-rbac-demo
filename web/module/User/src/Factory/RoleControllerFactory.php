<?php

namespace User\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use User\Controller\RoleController;
use Doctrine\ORM\EntityManager;

class RoleControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): RoleController
    {
        $entityManager = $container->get(EntityManager::class);
        return new RoleController(entityManager: $entityManager);
    }
}