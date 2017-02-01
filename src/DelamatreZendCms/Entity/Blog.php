<?php

namespace DelamatreZendCms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Custom blog
 *
 * @ORM\Entity
 * @ORM\Table(name="blog")
 */
class Blog extends Superclass\Content{

    /**
     * @ORM\Column(type="text")
     */
    protected $category;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $posted_timestamp;

    /**
     * @ORM\Column(type="text")
     */
    protected $contentShort;


    public function getImageThumb(){
        return '/img/blog/'.$this->imageThumb;
    }

    public function getImage(){
        return '/img/blog/'.$this->image;
    }

}
