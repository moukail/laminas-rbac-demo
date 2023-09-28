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
        $permission = (new Permission())
            ->setIdentifier('VIEW_DASHBOARD')
            ->setLabel('View dashboard')
        ;

        $manager->persist($permission);

        $role = (new Role())
            ->setName('ROLE_ADMIN')
            ->addPermission($permission)
        ;

        $manager->persist($role);

        $bcrypt = new Bcrypt();
        $securePass = $bcrypt->create('pass_1234');

        $user = (new User())
            ->setEmail('ismail@jcid.nl')
            ->setPassword($securePass)
            ->setFirstName('Ismail')
            ->setLastName('Moukafih')
            ->setRole($role)
        ;

        $manager->persist($user);
        $manager->flush();
    }
}