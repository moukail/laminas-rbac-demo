<?php

namespace Login\Form;

use Laminas\Form\Form;

class LoginForm extends Form {

    public function __construct($name = null)
    {
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' => 'Email',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'placeholder' => 'Wachtwoord',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'rememberme',
            'type'  => 'Checkbox',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Remember me',
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Aanmelden',
                'class' => 'btn btn-block signin',
                'id' => 'submitbutton',
            ),
        ));
    }
}