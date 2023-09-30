<?php

declare(strict_types=1);

namespace Dashboard\Controller;

use Exception;
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
            return $this->redirect()->toRoute('login');
            //throw new Exception("You have to log in", 401);
        }

        // Identity exists; get it
        $identity = $this->authenticationService->getIdentity();
        if(!$this->rbac->isGranted($identity->getRole()->getName(), 'VIEW_DASHBOARD')) {
            return $this->redirect()->toRoute('login');
            //throw new Exception("You don't have permission", 403);
        }

        return new ViewModel();
    }
}
