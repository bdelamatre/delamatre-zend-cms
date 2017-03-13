<?php

namespace DelamatreZendCmsAdmin\Form\Element;

use Zend\Form\Element\Select;

class GenerateSignature extends Select{

    const YES_AUTO   = 1;
    const YES_STATIC   = 2;
    const NO    = 0;

    public $valueOptions = array(
        self::YES_AUTO => 'Yes (Auto)',
        self::YES_STATIC => 'Yes (Static)',
        self::NO => 'No',
    );

    public function valueOptions(){
        return $this->valueOptions;
    }

    public function __construct($name=null,$options=array()){

        parent::__construct($name,$options);

        $this->setValueOptions($this->valueOptions());
        $this->setLabel('Generate Signature');

    }

}