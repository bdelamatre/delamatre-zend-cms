<?php

namespace DelamatreZendCmsAdmin\Form;

use DelamatreZendCmsAdmin\Form\Element\UserState;
use DelamatreZendCmsAdmin\Form\Element\UserType;
use Zend\Form\Form;

class UserForm extends Form{

    public function __construct($name=null){

        parent::__construct($name);

        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'username',
            'type' => 'text',
                'options' => array(
                    'label' => 'Username',
                'required' => true,
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'options' => array(
                'label' => 'E-Mail',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'text',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'password_confirm',
            'type' => 'text',
            'options' => array(
                'label' => 'Confirm Password',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'displayName',
            'type' => 'text',
            'options' => array(
                'label' => 'Display Name',
                'required' => true,
            ),
            'attributes' => array(
                //'placeholder' => 'John',
            ),
        ));

        $status = new \DelamatreZend\Form\Element\UserState('state');
        $this->add($status);

        $type = new \DelamatreZend\Form\Element\UserType('type');
        $this->add($type);

    }

}