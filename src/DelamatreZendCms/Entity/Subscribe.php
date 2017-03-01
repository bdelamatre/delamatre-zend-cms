<?php

namespace DelamatreZendCms\Entity;

use DelamatreZend\Entity\AbstractEntity;
use DelamatreZendCms\Entity\Traits\Tracking;
use DelamatreZendCms\Form\Element\Country;
use Doctrine\ORM\Mapping as ORM;

/**
 * Custom subscribe list
 *
 * @ORM\Entity
 * @ORM\Table(name="subscribe",indexes={
 *     @ORM\Index(name="index_email", columns={"email"}),
 *     @ORM\Index(name="index_created_timestamp", columns={"created_timestamp"}),
 * })
 */
class Subscribe extends AbstractEntity{

    use Tracking;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_timestamp;

    public function setCreatedToNow(){
        $this->created_timestamp = new \DateTime('now');
    }

}
