<?php

namespace DelamatreZendCms\Mvc\Controller;

use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

class AbstractActionController extends \DelamatreZend\Mvc\Controller\AbstractActionController{

    /**
     * Get the final lead entity for this application
     *
     * @param bool $nameOnly
     * @return \DelamatreZendCms\Entity\Lead
     */
    public function getLeadEntity($nameOnly=false){

        $name = $this->getConfig()['lead']['entity'];

        if($nameOnly==true){
            return $name;
        }else{
            return new $name;
        }
    }

    /**
     * Get CMS content using the content key
     *
     * @param $key
     * @return \DelamatreZendCms\Entity\Content
     * @throws \Exception
     */
    public function getContent($key){

        try {

            //query the content table using the content key
            $qb = $this->createQueryBuilder();
            $qb->select('c')->from('DelamatreZendCms\Entity\Content','c')->where('c.key=:key');
            $qb->setParameter('key',$key);
            /*  @var \DelamatreZendCms\Entity\Content $content ; */
            $content = $qb->getQuery()->getSingleResult();

        }catch (\Exception $e){

            throw new \Exception("Could not find content with key '$key'");

        }

        //handle the content type
        if($content->contentType=='page'){

            $this->getHeadTitle()->prepend($content->title);
            $this->setHeadMetaKeywords($content->keywords);
            $this->setHeadMetaDescription($content->description);


        }

        return $content;

    }

}