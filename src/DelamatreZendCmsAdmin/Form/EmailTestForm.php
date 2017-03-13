<?php

namespace DelamatreZendCmsAdmin\Form;

use DelamatreZendCmsAdmin\Form\Element\UserState;
use DelamatreZendCmsAdmin\Form\Element\UserType;
use Zend\Form\Form;

class EmailTestForm extends Form{

    public function __construct($name=null){

        parent::__construct($name);

        $this->add(array(
            'name' => 'name',
            'type' => 'text',
                'options' => array(
                    'label' => 'Recipient Name',
                'required' => true,
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'options' => array(
                'label' => 'Recipient E-Mail',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

    }

}