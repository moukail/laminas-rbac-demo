<?php

declare(strict_types=1);

namespace Dashboard\Controller;

use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Login\MyRbac;

class IndexController extends AbstractActionController
{
    public function __construct(private readonly AuthenticationService $authenticationService, private readonly MyRbac $rbac)
    {}

    public function indexAction()
    {
        if (!$this->authenticationService->hasIdentity()) {
            throw new \HttpException("You to log in", 401);
        }

        // Identity exists; get it
        $identity = $this->authenticationService->getIdentity();
        $this->rbac->isGranted($identity->getRole(), 'view.dashboard');

        return new ViewModel();
    }
}
