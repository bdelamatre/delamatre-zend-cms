<?php

namespace DelamatreZendCms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * A product application
 *
 * @ORM\Entity
 * @ORM\Table(name="content",indexes={
 *     @ORM\Index(name="index_contentType", columns={"contentType"}),
 *     @ORM\Index(name="index_key", columns={"key"}),
 *     @ORM\Index(name="index_title", columns={"title"}),
 *     @ORM\Index(name="index_created_datetime", columns={"created_datetime"}),
 *     @ORM\Index(name="index_updated_datetime", columns={"updated_datetime"}),
 *     @ORM\Index(name="index_active", columns={"active"}),
 *     @ORM\Index(name="index_find", columns={"key","active"}),
 *     @ORM\Index(name="index_sort", columns={"title","active"})
 * })
 */
class Content extends Superclass\Content{

    const CONTENT_TYPE_PAGE = 'page';

    /**
     * @ORM\Column(type="string")
     */
    public $contentType = self::CONTENT_TYPE_PAGE;

    /**
     * @ORM\ManyToMany(targetEntity="Email", mappedBy="pages")
     */
    public $emails;

    public function __construct() {
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Content types can be used to specify special handling
     *
     * @return array
     */
    public static function getAvailableContentTypes(){
        return array(
            self::CONTENT_TYPE_PAGE,
        );
    }

}
