<?php

namespace DelamatreZendCmsAdmin\Form;
use Doctrine\ORM\EntityManager;

/**
 * This is generally considered bad practice, but stuff needs to get done.
 *
 * Class DoctrineIntegration
 * @package DelamatreZendCmsAdmin\Form
 */
trait DoctrineIntegration{

    /**
     * @var EntityManager
     */
    public $entityManager;

    public function setEntityManager(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityManager
     * @throws \Exception
     */
    public function getEntityManager(){

        if(!$this->entityManager){
            throw new \Exception("Doctrine Entity Manager is not set on this form");
        }

        return $this->entityManager;
    }

    public function hasEntityManager(){
        if($this->entityManager){
            return true;
        }else{
            return false;
        }
    }

}