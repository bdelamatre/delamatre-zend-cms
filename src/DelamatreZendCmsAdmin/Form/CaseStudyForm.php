<?php

namespace DelamatreZendCmsAdmin\Form;

use DelamatreZend\Form\Element\DisplayOnWeb;

class CaseStudyForm extends \DelamatreZendCmsAdmin\Form\Superclass\ContentForm {

    public function __construct($name=null){

        parent::__construct($name);

        $displayOnWeb = new DisplayOnWeb('display_on_website');
        $this->add($displayOnWeb);

        $this->add(array(
            'name' => 'location',
            'type' => 'text',
            'options' => array(
                'label' => 'Location',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'latitude',
            'type' => 'text',
            'options' => array(
                'label' => 'Latitude',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'longitude',
            'type' => 'text',
            'options' => array(
                'label' => 'Longitude',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

    }

}