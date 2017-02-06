<?php

namespace DelamatreZendCms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * A product application
 *
 * @ORM\Entity
 * @ORM\Table(name="content")
 */
class Content extends Superclass\Content{

    const CONTENT_TYPE_PAGE = 'page';

    /**
     * @ORM\Column(type="string")
     */
    public $contentType = self::CONTENT_TYPE_PAGE;

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
