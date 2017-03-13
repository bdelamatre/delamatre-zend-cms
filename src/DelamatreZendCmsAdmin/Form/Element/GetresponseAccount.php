<?php

namespace DelamatreZendCmsAdmin\Form\Element;

use Zend\Form\Element\Select;

class GetresponseAccount extends Select{

    public function __construct($name=null,$accounts=array(), $options=array()){

        parent::__construct($name,$options);

        $valueOptions = array(''=>'');

        //query users from sales
        foreach($accounts as $account){
            $valueOptions[$account] = $account;
        }

        $this->setValueOptions($valueOptions);
        $this->setLabel('Getresponse Account');

    }

}