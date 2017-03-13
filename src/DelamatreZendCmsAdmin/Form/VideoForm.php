<?php

namespace DelamatreZendCmsAdmin\Form;

use DelamatreZend\Form\Element\DisplayOnWeb;

class VideoForm extends \DelamatreZendCmsAdmin\Form\Superclass\ContentForm {

    public function __construct($name=null){

        parent::__construct($name);

        $displayOnWeb = new DisplayOnWeb('display_on_website');
        $this->add($displayOnWeb);

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
            'name' => 'youtubeUrl',
            'type' => 'text',
            'options' => array(
                'label' => 'Youtube URL',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

    }

}