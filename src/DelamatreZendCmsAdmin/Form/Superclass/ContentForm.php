<?php

namespace DelamatreZendCmsAdmin\Form\Superclass;

use Zend\Form\Form;

class ContentForm extends Form{

    public function __construct($name=null){

        parent::__construct($name);

        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'key',
            'type' => 'text',
                'options' => array(
                'label' => 'Unique Key',
                'required' => true,
            ),
            'attributes' => array(
                'required' => true,
                'placeholder' => 'unique-key',
            ),
        ));

        $this->add(array(
            'name' => 'title',
            'type' => 'text',
            'options' => array(
                'label' => 'Title',
            ),
            'attributes' => array(
                'required' => true,
                'placeholder' => 'Title',
            ),
        ));

        $this->add(array(
            'name' => 'description',
            'type' => 'text',
            'options' => array(
                'label' => 'Description',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'keywords',
            'type' => 'text',
            'options' => array(
                'label' => 'Keywords',
                'required' => true,
            ),
            'attributes' => array(
                //'placeholder' => 'John',
            ),
        ));

        $this->add(array(
            'name' => 'content',
            'type' => 'text',
            'options' => array(
                'label' => 'Content',
            ),
            'attributes' => array(
                'id' => 'content',
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'imageThumb',
            'type' => 'text',
            'options' => array(
                'label' => 'Image Thumb',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'image',
            'type' => 'text',
            'options' => array(
                'label' => 'Image',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));


        $this->add(array(
            'name' => 'imageMenu',
            'type' => 'text',
            'options' => array(
                'label' => 'Image Menu',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'descriptionMenu',
            'type' => 'text',
            'options' => array(
                'label' => 'Description Menu',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));


    }

}