<?php

namespace DelamatreZendCmsAdmin\Controller;


use DelamatreZendCmsAdmin\Mvc\Controller\AbstractEntityAdminController;

class BlogController extends AbstractEntityAdminController
{

    public $routeName = 'blog';
    public $entityName = 'DelamatreZendCms\Entity\Blog';
    public $formName = 'DelamatreZendCmsAdmin\Form\BlogForm';

    public function buildQuery()
    {
        $qb = parent::buildQuery();
        $qb->orderBy('u.posted_timestamp','DESC');
        return $qb;
    }

    public function crudBusinessRules(\DelamatreZendCms\Entity\Superclass\Content $blog){

        if(!$blog->created_datetime){
            //backwards compatability for posted_timestamp
            if($blog->posted_timestamp){
                $blog->created_datetime = $blog->posted_timestamp;
            }else{
                $blog->created_datetime = new \DateTime('now');
                $blog->posted_timestamp = new \DateTime('now');
            }
        }

        $blog->updated_datetime = new \DateTime('now');

    }

}
