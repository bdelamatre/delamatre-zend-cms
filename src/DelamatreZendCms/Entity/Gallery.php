<?php

namespace DelamatreZendCms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="gallery")
 */
class Gallery extends Superclass\Content{

    /**
     * @ORM\Column(type="string")
     */
    protected $link;

    /**
     * @ORM\Column(type="text")
     */
    protected $category;
    

    public function getImageThumb(){
        return '/img/gallery/'.$this->category.'/'.$this->imageThumb;
    }

    public function getImage(){
        return '/img/gallery/'.$this->category.'/'.$this->image;
    }

}
