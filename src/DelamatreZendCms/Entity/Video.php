<?php

namespace DelamatreZendCms\Entity;

use DelamatreZendCms\Entity\Superclass\Content as SuperclassContent;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="video",indexes={
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
 * @ORM\DiscriminatorMap({"video"="Video","custom-video"="Application\Entity\Video"})
 */
class Video extends SuperclassContent{

    /**
     * @ORM\Column(type="string")
     */
    protected $youtubeUrl;

    public function getUrl(){
        return $this->youtubeUrl;
    }

    public function getImageThumb(){
        return '/img/video/'.$this->imageThumb;
    }

    public function getImage(){
        return '/img/video/'.$this->image;
    }

}