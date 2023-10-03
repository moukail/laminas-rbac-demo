<?php

namespace Application\View\Helper;

use Application\Entity\Role;
use Application\Entity\User;
use Laminas\Authentication\AuthenticationService;
use Laminas\View\Helper\AbstractHelper;
use Application\Service\RbacService;

class RbacViewHelper extends AbstractHelper
{
    public function __construct(
        private readonly AuthenticationService $authenticationService,
        private readonly RbacService $rbacService) {}

    public function __invoke()
    {
        return $this;
    }

    public function isGranted(string $permission): bool
    {
        /** @var User $user */
        $user = $this->authenticationService->getIdentity();
        $role = $user?->getRole();
        $roleName = $role?->getName() ?? Role::ROLE_GUEST;

        return $this->rbacService->isGranted($roleName, $permission);
    }
}