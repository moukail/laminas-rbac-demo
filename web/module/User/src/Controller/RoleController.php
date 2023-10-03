<?php

namespace User\Controller;

use Application\Entity\Role;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Form\RoleForm;

class RoleController extends AbstractActionController
{
    public function __construct(
        private readonly EntityManager $entityManager
        //private readonly FlashMessenger $flashMessenger
    ) {}

    public function indexAction(): ViewModel
    {
        $roles = $this->entityManager->getRepository(Role::class)->findAll();

        return new ViewModel(['roles' => $roles]);
    }

    public function addAction()
    {
        $form = new RoleForm($this->entityManager);

        if (!$this->getRequest()->isPost() || !$form->isValid()){
            return new ViewModel(['form' => $form]);
        }

        $form->setData($this->getRequest()->getPost());

        $roleData = $form->getData();
        $role = new Role();
        $role->setName($roleData['name']);

        // Persist and flush the role entity
        $this->entityManager->persist($role);
        $this->entityManager->flush();

        return $this->redirect()->toRoute('role-index');
    }

    public function editAction()
    {
        $roleId = (int) $this->params()->fromRoute('id', 0);
        $role = $this->entityManager->getRepository(Role::class)->find($roleId);

        if (!$role) {
            return $this->notFoundAction();
        }

        $form = new RoleForm($this->entityManager);
        $form->bind($role);

        if (!$this->getRequest()->isPost() || !$form->isValid()){
            return new ViewModel(['form' => $form, 'role' => $role]);
        }

        $form->setData($this->getRequest()->getPost());
        $this->entityManager->persist($role);
        $this->entityManager->flush();

        return $this->redirect()->toRoute('role-index');
    }

    public function deleteAction()
    {
        $roleId = (int) $this->params()->fromRoute('id', 0);
        $role = $this->entityManager->getRepository(Role::class)->find($roleId);

        if (!$role) {
            return $this->notFoundAction();
        }

        if (!$this->getRequest()->isPost()) {
            return new ViewModel(['role' => $role]);
        }

        $confirmation = $this->params()->fromPost('confirmation', 'no');

        if ($confirmation === 'Yes') {
            $this->entityManager->remove($role);
            $this->entityManager->flush();
        }

        return $this->redirect()->toRoute('role-index');
    }
}