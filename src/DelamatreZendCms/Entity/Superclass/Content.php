<?php

namespace DelamatreZendCms\Entity\Superclass;

use DelamatreZend\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;

/**
 * @ORM\MappedSuperclass
 */
class Content extends AbstractEntity{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(name="`key`",type="string",unique=true)
     */
    public $key;

    /**
     * @ORM\Column(type="string")
     */
    public $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $keywords;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    public $sortOrder;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public $image;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public $imageThumb;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public $imageMenu;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    public $descriptionMenu;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $content;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $created_datetime;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $updated_datetime;

    /**
     * @ORM\Column(type="boolean")
     */
    public $active = true;


    public function getFolderName(){
        return(strtolower(__CLASS__));
    }

    public function getImageThumb(){
        return '/img/'.$this->getFolderName().'/'.$this->imageThumb;
    }

    public function getImage(){
        return '/img/'.$this->getFolderName().'/'.$this->image;
    }

    public function __toString()
    {
        return (string)$this->content;
    }

}
