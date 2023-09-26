<?php

declare(strict_types=1);

namespace Login\Controller;

use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Login\Form\LoginForm;

class IndexController extends AbstractActionController
{
    public function __construct(private readonly AuthenticationService $authenticationService)
    {}

    public function indexAction()
    {
        $form = new LoginForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $data = $this->getRequest()->getPost();

        $adapter = $this->authenticationService->getAdapter();
        $adapter->setIdentity($data['username']);
        $adapter->setCredential($data['password']);
        $authResult = $this->authenticationService->authenticate();

        if ($authResult->isValid()) {
            return $this->redirect()->toRoute('home');
        }

        return new ViewModel([
            'error' => 'Your authentication credentials are not valid',
        ]);
    }
}
