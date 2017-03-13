<?php

namespace DelamatreZendCmsAdmin\Form;

use DelamatreZendCmsAdmin\Form\Element\Technology;
use DelamatreZendCmsAdmin\Form\Element\WhitePaper;
use Zend\Form\Form;

class SelectWhitePaper extends Form{

    use DoctrineIntegration;

    public function __construct($name=null,$options=array()){

        //grab the entity manager from options
        if(isset($options['entityManager'])){
            $this->setEntityManager($options['entityManager']);
        }

        if(isset($options['exclude'])){
            $exclude = $options['exclude'];
        }else{
            $exclude = array();
        }

        parent::__construct($name,$options);

        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));

        $owner = new WhitePaper('white-paper',array('exclude'=>$exclude),$this->getEntityManager());
        $owner->setAttributes(array('required'=>true));
        //$owner->setLabel('Technology');

        $this->add($owner);

    }

}