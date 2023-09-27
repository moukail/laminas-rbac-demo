<?php

namespace Login;

use Application\Entity\Role;
use Doctrine\ORM\EntityManager;
use Laminas\Permissions\Rbac\Rbac;

class MyRbac extends Rbac
{

    public function __construct(private readonly EntityManager $entityManager)
    {
        $roles = $entityManager->getRepository('Application\Entity\Role')->findAll();

        /** @var Role $role */
        foreach ($roles as $role){
            $this->addRole($role);
        }

    }
}