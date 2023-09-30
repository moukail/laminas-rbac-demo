<?php

namespace Login;

use Application\Entity\Permission;
use Application\Entity\Role;
use Doctrine\ORM\EntityManager;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Permissions\Rbac\Role as RbacRole;

class MyRbac extends Rbac
{

    public function __construct(private readonly EntityManager $entityManager)
    {
        $roles = $entityManager->getRepository(Role::class)->findAll();

        /** @var Role $role */
        foreach ($roles as $role){

            $rbacRole = new RbacRole($role->getName());

            /** @var Permission $permission */
            foreach ($role->getPermissions() as $permission){
                $rbacRole->addPermission($permission->getIdentifier());
            }

            //$rbacRole->addChild($child);
            $this->addRole($rbacRole);
        }

    }
}