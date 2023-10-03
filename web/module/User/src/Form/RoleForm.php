<?php

namespace User\Form;

use Application\Entity\Permission;
use Doctrine\Persistence\ObjectManager;
use DoctrineModule\Form\Element\ObjectMultiCheckbox;
use Laminas\Form\Form;
use Laminas\Form\Element;

class RoleForm extends Form
{
    public function __construct(private readonly ObjectManager $objectManager)
    {
        parent::__construct('role-form');

        $this->add([
            'name' => 'name',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Role Name',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'type' => ObjectMultiCheckbox::class,
            'name' => 'permissions',
            'options' => [
                'label' => 'Permissions',
                'object_manager' => $this->objectManager,
                'target_class' => Permission::class,
                'property' => 'label',
                'is_method' => true,
                'find_method' => [
                    'name' => 'findAll',
                ],
            ],
            'attributes' => [
                'class' => 'form-check-input',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Element\Submit::class,
            'attributes' => [
                'value' => 'Save',
                'class' => 'btn btn-primary',
            ],
        ]);


    }
}