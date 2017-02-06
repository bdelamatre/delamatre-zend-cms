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
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string",unique=true)
     */
    public $key;

    /**
     * @ORM\Column(type="string")
     */
    public $title;

    /**
     * @ORM\Column(type="text")
     */
    public $description;

    /**
     * @ORM\Column(type="text")
     */
    public $keywords;

    /**
     * @ORM\Column(type="integer")
     */
    public $sortOrder;

    /**
     * @ORM\Column(type="string")
     */
    public $image;

    /**
     * @ORM\Column(type="string")
     */
    public $imageThumb;

    /**
     * @ORM\Column(type="string")
     */
    public $imageMenu;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    public $descriptionMenu;

    /**
     * @ORM\Column(type="text")
     */
    public $content;

    /**
     * @ORM\Column(type="datetime")
     */
    public $created_datetime;

    /**
     * @ORM\Column(type="datetime")
     */
    public $updated_datetime;

    /**
     * @ORM\Column(type="boolean")
     */
    public $active;

    /*public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }


        return $this->inputFilter;
    }*/

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
