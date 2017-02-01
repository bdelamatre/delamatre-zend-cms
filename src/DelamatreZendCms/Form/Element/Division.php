<?php

namespace DelamatreZendCms\Form\Element;

use Zend\Form\Element\Select;

class Division extends Select{

    public static function options(){
        return array(
            'Vulcan' => 'Vulcan',
            'Tuffman' => 'Tuffman',
            'Worldwide Recycling' => 'Worldwide Recycling',
        );
    }

    public function __construct($name=null,$options=array()){

        parent::__construct($name,$options);

        $this->setValueOptions(self::options());
        $this->setLabel('Division');

    }

}