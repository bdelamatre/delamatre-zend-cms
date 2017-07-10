<?php

namespace DelamatreZendCms\Entity;

use DelamatreZendCms\Entity\Superclass\Content as SuperclassContent;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="document",indexes={
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
 * @ORM\DiscriminatorMap({"docuemnt"="Document"})
 */
class Document extends SuperclassContent{

    /**
     * @ORM\Column(type="boolean")
     */
    public $display_on_website = 0;

    /**
     * @ORM\Column(type="string")
     */
    public $download;

    /**
     * @ORM\Column(type="text")
     */
    public $category;

    /**
     * @ORM\ManyToMany(targetEntity="Email", mappedBy="documents")
     */
    public $emails;

    public function __construct() {
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getDownload(){
        return $this->download;
    }

    public function getImageThumb(){
        return $this->imageThumb;
    }

    public function getImage(){
        return $this->image;
    }

    public function getUrl(){
        $this->getDownload();
    }

}