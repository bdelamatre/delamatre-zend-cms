<?php

namespace DelamatreZendCmsAdmin\Form\Element;

use Doctrine\ORM\EntityManager;
use Zend\Form\Element\Select;

class EmailTemplate extends Select{

    public function __construct($name=null, $options=array(), EntityManager $entityManager){

        parent::__construct($name,$options);

        $valueOptions = array(''=>'');

        $qb = $entityManager->createQueryBuilder();
        $qb->select('t')->from('DelamatreZendCms\Entity\EmailTemplate','t')->where('t.active=1')->orderBy('t.title','ASC');

        if(!empty($options['exclude'])){
            $qb->andWhere($qb->expr()->notIn('t.id',$options['exclude']));
        }

        $technologies = $qb->getQuery()->getArrayResult();

        //query users from sales
        foreach($technologies as $technology){
            $valueOptions[$technology['id']] = $technology['title'];
        }

        $this->setValueOptions($valueOptions);
        $this->setLabel('E-Mail Template');

    }

}