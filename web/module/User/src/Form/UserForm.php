<?php

namespace User\Form;

use Application\Entity\Role;
use Doctrine\ORM\EntityManager;
use Laminas\Form\Element\Select;
use Laminas\Form\Form;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Submit;

class UserForm extends Form
{
    public function __construct(private readonly EntityManager $entityManager)
    {
        parent::__construct('user-form');

        $this->add([
            'type' => Select::class,
            'name' => 'role',
            'options' => [
                'label' => 'Role',
                'value_options' => $this->getRoleOptions(),
            ],
        ]);

        $this->add([
            'name' => 'first_name',
            'type' => Text::class,
            'options' => [
                'label' => 'First Name',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name' => 'last_name',
            'type' => Text::class,
            'options' => [
                'label' => 'Last Name',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => Email::class,
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name' => 'plainPassword',
            'type' => Password::class,
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'attributes' => [
                'value' => 'Edit',
                'class' => 'btn btn-primary w-100 py-2',
            ],
        ]);
    }

    private function getRoleOptions(): array
    {
        // Retrieve role options from the database (e.g., using Doctrine)
        $roles = $this->entityManager->getRepository(Role::class)->findAll();

        $options = [];

        foreach ($roles as $role) {
            $options[$role->getId()] = $role->getName();
        }

        return $options;
    }
}