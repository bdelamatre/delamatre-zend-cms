<?php

namespace DelamatreZendCms\Controller;

use DelamatreZendCms\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BlogController extends AbstractActionController
{

    public function indexAction(){

        $category = $this->params('category','all');

        $blogQb = $this->createQueryBuilder()->select('b')
            ->from('DelamatreZendCms\Entity\Blog','b')
            ->where('b.active=1')
            ->orderBy('b.posted_timestamp','DESC')
            ->orderBy('b.id','DESC');

        if($category!='all'){
            $blogQb->andWhere('b.category=:category');
            $blogQb->setParameter('category',$category);
        }

        $blog = $blogQb->getQuery()->getResult();

        $categories = $this->createQueryBuilder()->select('b.category, COUNT(b.category)')
            ->from('DelamatreZendCms\Entity\Blog','b')
            ->where('b.active=1')
            ->orderBy('b.category','ASC')
            ->groupBy('b.category')
            ->getQuery()->getArrayResult();

        //prepare view
        $view = new ViewModel();
        $view->blog = $blog;
        $view->content = $this->getContent('blog');
        $view->categories = $categories;
        $view->category = $category;
        return $view;
    }


    public function postAction(){

        $key = $this->params('key',false);
        $category = $this->params('category','all');

        if(empty($key)){
            throw new \Exception("must define a a key");
        }

        /* @var $post \DelamatreZendCms\Entity\Blog */
        $post = $this->createQueryBuilder()->select('a')
            ->from('DelamatreZendCms\Entity\Blog','a')
            ->where('a.key=:key')
            ->setParameter('key',$key)
            ->getQuery()->getSingleResult();

        if(empty($post)){
            throw new \Exception("blog post with key `$key` not found");
        }

        //prepare view
        $view = new ViewModel();
        $view->content = $this->getContent('blog');
        $view->post = $post;
        $view->category = $category;

        //prepare header
        $this->getHeadTitle()->prepend($post->title);
        $this->setHeadMetaKeywords($post->keywords);
        $this->setHeadMetaDescription($post->description);

        return $view;
    }

}