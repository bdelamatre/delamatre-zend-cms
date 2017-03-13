<?php

namespace DelamatreZendCmsAdmin\Form;

class EmailTemplateForm extends \DelamatreZendCmsAdmin\Form\Superclass\ContentForm {

    public function __construct($name=null){

        parent::__construct($name);

        $this->add(array(
            'name' => 'theme_color',
            'type' => 'text',
            'options' => array(
                'label' => 'Theme Color',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

    }

}