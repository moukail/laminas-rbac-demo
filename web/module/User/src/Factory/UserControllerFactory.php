<?php

namespace User\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use User\Controller\UserController;
use Doctrine\ORM\EntityManager;

class UserControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): UserController
    {
        $entityManager = $container->get(EntityManager::class);
        return new UserController(entityManager: $entityManager);
    }
}