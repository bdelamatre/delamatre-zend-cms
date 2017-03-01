<?php

namespace DelamatreZendCms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Custom blog
 *
 * @ORM\Entity
 * @ORM\Table(name="blog",indexes={
 *     @ORM\Index(name="index_category", columns={"category"}),
 *     @ORM\Index(name="index_posted_timestamp", columns={"posted_timestamp"}),
 *     @ORM\Index(name="index_key", columns={"key"}),
 *     @ORM\Index(name="index_title", columns={"title"}),
 *     @ORM\Index(name="index_created_datetime", columns={"created_datetime"}),
 *     @ORM\Index(name="index_updated_datetime", columns={"updated_datetime"}),
 *     @ORM\Index(name="index_active", columns={"active"}),
 *     @ORM\Index(name="index_find", columns={"key","active"}),
 *     @ORM\Index(name="index_sort", columns={"title","active"})
 *
 * })
 */
class Blog extends Superclass\Content{

    /**
     * @ORM\Column(type="string")
     */
    public $category;

    /**
     * @ORM\Column(type="datetime")
     */
    public $posted_timestamp;

    /**
     * @ORM\Column(type="text")
     */
    public $contentShort;


    public function getImageThumb(){
        return '/img/blog/'.$this->imageThumb;
    }

    public function getImage(){
        return '/img/blog/'.$this->image;
    }

}
