<?php

namespace DelamatreZendCms\Entity;

use DelamatreZendCms\Entity\Superclass\Content as SuperclassContent;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="case_study",indexes={
 *     @ORM\Index(name="index_key", columns={"key"}),
 *     @ORM\Index(name="index_title", columns={"title"}),
 *     @ORM\Index(name="index_created_datetime", columns={"created_datetime"}),
 *     @ORM\Index(name="index_updated_datetime", columns={"updated_datetime"}),
 *     @ORM\Index(name="index_active", columns={"active"}),
 *     @ORM\Index(name="index_find", columns={"key","active"}),
 *     @ORM\Index(name="index_sort", columns={"title","active"})
 * })
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="record_type", type="string")
 * @ORM\DiscriminatorMap({"case-study"="CaseStudy"})
 */
class CaseStudy extends SuperclassContent{

    /**
     * @ORM\Column(type="boolean")
     */
    public $display_on_website = 0;

    /**
     * @ORM\Column(type="string")
     */
    public $location;

    /**
     * @ORM\Column(type="float",nullable=true)
     */
    public $latitude;

    /**
     * @ORM\Column(type="float",nullable=true)
     */
    public $longitude;

    /**
     * @ORM\ManyToMany(targetEntity="Email", mappedBy="caseStudies")
     */
    public $emails;

    public function __construct() {
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getImageThumb(){
        return $this->imageThumb;
    }

    public function getImage(){
        return $this->image;
    }

    public function getUrl(){
        return '/case-study/'.$this->key;
    }

}