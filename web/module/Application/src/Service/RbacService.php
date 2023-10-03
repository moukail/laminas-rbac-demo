<?php

namespace Application\Service;

use Application\Entity\Permission;
use Application\Entity\Role;
use Doctrine\ORM\EntityManager;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Permissions\Rbac\Role as RbacRole;

class RbacService extends Rbac
{

    public function __construct(private readonly EntityManager $entityManager)
    {
        $roles = $entityManager->getRepository(Role::class)->findAll();

        /** @var Role $role */
        foreach ($roles as $role){

            $rbacRole = new RbacRole($role->getName());

            $rbacRole->addPermission('home');
            //$rbacRole->addPermission('user-login');
            $rbacRole->addPermission('user-logout');

            /** @var Permission $permission */
            foreach ($role->getPermissions() as $permission){
                $rbacRole->addPermission($permission->getIdentifier());
            }

            //$rbacRole->addChild($child);
            $this->addRole($rbacRole);
        }

        $guestRole = new RbacRole(Role::ROLE_GUEST);
        $guestRole->addPermission('home');
        $guestRole->addPermission('user-login');
        $guestRole->addPermission('user-register');
        $this->addRole($guestRole);

    }
}