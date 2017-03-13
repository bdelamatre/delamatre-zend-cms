<?php

namespace DelamatreZendCmsAdmin\Form\Element;

use Zend\Form\Element\Select;

class SignatureTemplate extends Select{

    const TEMPLATE_DEFAULT          = self::TEMPLATE_VULCAN;
    const TEMPLATE_VULCAN           = 'vulcan';
    const TEMPLATE_VULCAN_SIMPLE    = 'vulcan-simple';

    public $valueOptions = array(
        self::TEMPLATE_DEFAULT          => 'Default (Vulcan)',
        self::TEMPLATE_VULCAN           => 'Vulcan',
        self::TEMPLATE_VULCAN_SIMPLE    => 'Vulcan (Simple)',
    );

    public function valueOptions(){
        return $this->valueOptions;
    }

    public function __construct($name=null,$options=array()){

        parent::__construct($name,$options);

        $this->setValueOptions($this->valueOptions());
        $this->setLabel('Signature Template');

    }

}