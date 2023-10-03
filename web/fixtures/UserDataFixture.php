<?php

namespace DataFixtures;

use Application\Entity\Permission;
use Application\Entity\Role;
use Application\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Laminas\Crypt\Password\Bcrypt;

class UserDataFixture implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $viewDashboardPermission = (new Permission())
            ->setIdentifier('dashboard')
            ->setLabel('View dashboard')
        ;
        $manager->persist($viewDashboardPermission);

        $userListPermission = (new Permission())
            ->setIdentifier('user-index')
            ->setLabel('User list')
        ;
        $manager->persist($userListPermission);

        $viewProfilePermission = (new Permission())
            ->setIdentifier('user-profile')
            ->setLabel('View profile')
        ;
        $manager->persist($viewProfilePermission);

        $roleAdmin = (new Role())
            ->setName(Role::ROLE_ADMIN)
            ->addPermission($viewDashboardPermission)
            ->addPermission($userListPermission)
            ->addPermission($viewProfilePermission)
        ;
        $manager->persist($roleAdmin);

        $roleUser = (new Role())
            ->setName(Role::ROLE_USER)
            ->addPermission($viewProfilePermission)
        ;
        $manager->persist($roleUser);

        $bcrypt = new Bcrypt();
        $securePass = $bcrypt->create('pass_1234');

        $user = (new User())
            ->setEmail('ismail@moukafih.nl')
            ->setPassword($securePass)
            ->setFirstName('Ismail')
            ->setLastName('Moukafih')
            ->setRole($roleAdmin)
        ;

        $manager->persist($user);
        $manager->flush();
    }
}