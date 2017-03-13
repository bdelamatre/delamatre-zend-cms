<?php

namespace DelamatreZendCmsAdmin\Form;

class BlogForm extends \DelamatreZendCmsAdmin\Form\Superclass\ContentForm {

    public function __construct($name=null){

        parent::__construct($name);

        $this->add(array(
            'name' => 'category',
            'type' => 'text',
            'options' => array(
                'label' => 'Category',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'contentShort',
            'type' => 'text',
            'options' => array(
                'label' => 'Content Short',
            ),
            'attributes' => array(
                'id' => 'contentShort',
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

    }

}