<?php

declare(strict_types=1);

namespace Login\Controller;

use Application\Entity\Role;
use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Login\Form\LoginForm;

class IndexController extends AbstractActionController
{
    public function __construct(private readonly AuthenticationService $authenticationService)
    {}

    public function loginAction()
    {
        $form = new LoginForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $data = $this->getRequest()->getPost();

        $adapter = $this->authenticationService->getAdapter();

        $adapter->setIdentity($data['email']);
        $adapter->setCredential($data['password']);
        $authResult = $this->authenticationService->authenticate();

        if (!$authResult->isValid()) {
            return new ViewModel([
                'error' => 'Your authentication credentials are not valid',
            ]);
        }

        $identity = $authResult->getIdentity();
        $this->authenticationService->getStorage()->write($identity);

        if ($identity->getRole()->getName() == Role::ROLE_ADMIN){
            return $this->redirect()->toRoute('dashboard');
        }

        return $this->redirect()->toRoute('user-profile');
    }

    public function logoutAction()
    {
        //$identity = $this->authenticationService->getIdentity();
        //$this->getEventManager()->trigger(AccessEvent::EVENT_LOGOUT, null, ['email' => $identity->getEmail()]);
        $this->authenticationService->clearIdentity();
        return $this->redirect()->toRoute('user-login');
    }
}
