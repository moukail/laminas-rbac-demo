<?php

namespace User\Controller;

use Application\Entity\Role;
use Application\Entity\User;
use Doctrine\ORM\EntityManager;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\View\Helper\FlashMessenger;
use Laminas\View\Model\ViewModel;
use User\Form\RegistrationForm;
use User\Form\UserForm;

class UserController extends AbstractActionController
{
    public function __construct(
        private readonly EntityManager $entityManager,
        //private readonly FlashMessenger $flashMessenger
    ) {}

    public function indexAction()
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $users = $userRepository->findAll();

        return new ViewModel([
            'users' => $users,
        ]);
    }

    public function viewAction()
    {
        $userId = $this->params()->fromRoute('id');
        $user = $this->entityManager->getRepository(User::class)->find($userId);

        if (!$user) {
            // Set a flash message and redirect to the index page
            //$this->flashMessenger->addErrorMessage('User not found.');
            return $this->redirect()->toRoute('user');
        }

        return new ViewModel([
            'user' => $user,
        ]);
    }

    public function profileAction()
    {
        $identity = $this->authenticationService->getIdentity();

        if (!$identity) {
            return $this->notFoundAction();
        }

        return new ViewModel([
            'user' => $identity,
        ]);
    }

    public function registerAction()
    {
        $form = new RegistrationForm();
        $request = $this->getRequest();

        if (!$this->getRequest()->isPost() || !$form->isValid()){
            return new ViewModel(['form' => $form]);
        }

        $data = $request->getPost()->toArray();
        $form->setData($data);

        $user = new User();
        $user->setFirstName($form->get('first_name')->getValue());
        $user->setLastName($form->get('last_name')->getValue());
        $user->setEmail($form->get('email')->getValue());

        $bcrypt = new Bcrypt(['cost' => 10]);
        $hashedPassword = $bcrypt->create($form->get('plainPassword')->getValue());
        $user->setPassword($hashedPassword);

        $role = $this->entityManager->getRepository(Role::class)->findOneBy(['name' => Role::ROLE_USER]);
        $user->setRole($role);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Add a success message and redirect to a success page or login page
        //$this->flashMessenger()->addSuccessMessage('User registered successfully.');

        return $this->redirect()->toRoute('success');

    }

    public function successAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
        $form = new UserForm($this->entityManager);

        if (!$this->getRequest()->isPost() || !$form->isValid()){
            return new ViewModel(['form' => $form]);
        }

        $form->setData($this->getRequest()->getPost());
        $userData = $form->getData();

        $role = $this->entityManager->getRepository(Role::class)->findOneBy(['name' => Role::ROLE_USER]);

        $bcrypt = new Bcrypt(['cost' => 10]);
        $hashedPassword = $bcrypt->create($userData['plainPassword']);

        $user = (new User())
            ->setEmail($userData['email'])
            ->setFirstName($userData['first_name'])
            ->setLastName($userData['last_name'])
            ->setPassword($hashedPassword)
            ->setRole($role)
        ;

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirect()->toRoute('user-index');
    }

    public function editAction()
    {
        $userId = (int) $this->params()->fromRoute('id', 0);
        $user = $this->entityManager->getRepository(User::class)->find($userId);

        if (!$user) {
            return $this->notFoundAction();
        }

        $form = new UserForm($this->entityManager);
        $form->bind($user);

        if (!$this->getRequest()->isPost() || !$form->isValid()){
            return new ViewModel(['form' => $form, 'user' => $user]);
        }

        $form->setData($this->getRequest()->getPost());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirect()->toRoute('user-index');
    }

    public function deleteAction()
    {
        $userId = (int) $this->params()->fromRoute('id', 0);
        $user = $this->entityManager->getRepository(User::class)->find($userId);

        if (!$user) {
            return $this->notFoundAction();
        }

        if (!$this->getRequest()->isPost()) {
            return new ViewModel(['user' => $user]);
        }

        $confirmation = $this->params()->fromPost('confirmation', 'no');

        if ($confirmation === 'Yes') {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }

        return $this->redirect()->toRoute('user-index');
    }
}