<?php

namespace Application\View\Helper;

use Psr\Container\ContainerInterface;
use Application\Service\RbacService;

class RbacViewHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $authenticationService = $container->get('doctrine.authenticationservice.orm_default');
        $rbacService = $container->get(RbacService::class);

        return new RbacViewHelper($authenticationService, $rbacService);
    }
}