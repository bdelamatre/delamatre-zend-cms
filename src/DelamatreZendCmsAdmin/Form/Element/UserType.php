<?php

namespace DelamatreZendCmsAdmin\Form\Element;

use DelamatreZend\Entity\User;
use Zend\Form\Element\Select;

class UserType extends Select{

    public static function valueOptions(){
        $options = User::$userTypes;
        return $options;
    }

    public function __construct($name=null,$options=array()){

        parent::__construct($name,$options);

        $this->setValueOptions(self::valueOptions());
        $this->setLabel('User Type');

    }

}