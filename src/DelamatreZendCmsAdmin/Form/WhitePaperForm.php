<?php

namespace DelamatreZendCmsAdmin\Form;

use DelamatreZend\Form\Element\DisplayOnWeb;

class WhitePaperForm extends \DelamatreZendCmsAdmin\Form\Superclass\ContentForm {

    public function __construct($name=null){

        parent::__construct($name);

        $displayOnWeb = new DisplayOnWeb('display_on_website');
        $this->add($displayOnWeb);

    }

}