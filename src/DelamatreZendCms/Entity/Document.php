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
 * @ORM\DiscriminatorMap({"docuemnt"="Document","custom-document"="Application\Entity\Document"})
 */
class Document extends SuperclassContent{

    /**
     * @ORM\Column(type="string")
     */
    protected $download;

    /**
     * @ORM\Column(type="text")
     */
    protected $category;
    

    public function getDownload(){
        return '/doc/doc/'.($this->download);
    }

    public function getImageThumb(){
        return '/img/doc/'.$this->imageThumb;
    }

    public function getImage(){
        return '/img/doc/'.$this->image;
    }

}