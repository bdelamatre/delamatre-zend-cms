<?php

namespace DelamatreZendCms\Entity;

use DelamatreZendCms\Entity\Superclass\Content as SuperclassContent;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="white_paper",indexes={
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
 * @ORM\DiscriminatorMap({"white-paper"="WhitePaper","custom-white-paper"="Application\Entity\WhitePaper"})
 */
class WhitePaper extends SuperclassContent{

    /**
     * @ORM\Column(type="boolean")
     */
    public $display_on_website = 0;

    /**
     * @ORM\ManyToMany(targetEntity="Email", mappedBy="whitePapers")
     */
    public $emails;

    public function __construct() {
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getDownload(){
        return $this->getImage();
    }

    public function getImage(){
        return '/doc/white-paper/'.($this->image);
    }

}