<?php

namespace DelamatreZendCmsAdmin\Form\Element;

use Zend\Form\Element\Select;

class AttachFiles extends Select{

    const YES   = 1;
    const NO    = 0;

    public $valueOptions = array(
        self::YES => 'Yes',
        self::NO => 'No',
    );

    public function valueOptions(){
        return $this->valueOptions;
    }

    public function __construct($name=null,$options=array()){

        parent::__construct($name,$options);

        $this->setValueOptions($this->valueOptions());
        $this->setLabel('Attach Files');

    }

}