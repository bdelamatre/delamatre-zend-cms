<?php

namespace DelamatreZendCmsAdmin\Form;

class ContentForm extends \DelamatreZendCmsAdmin\Form\Superclass\ContentForm {

    public function __construct($name=null){

        parent::__construct($name);

        $this->add(array(
            'name' => 'contentType',
            'type' => 'text',
            'options' => array(
                'label' => 'Content Type',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

    }

}