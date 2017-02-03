<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace DelamatreZendCms\Controller;

use DelamatreZendCms\Entity\Lead;
use DelamatreZendCms\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    //default home
    public function indexAction()
    {

        //by default we are going to prepare a gallery
        $galleryCategory = 'home';
        $qb = $this->createQueryBuilder();
        $qb->select(array('g'))->from('DelamatreZendCms\Entity\Gallery','g')->where('g.category=:category')->setParameter('category',$galleryCategory);
        $gallery = $qb->getQuery()->getResult();

        //by default we are going to prepare a blog
        $qb = $this->createQueryBuilder();
        $qb->select(array('b'))->from('DelamatreZendCms\Entity\Blog','b')->orderBy('b.id','DESC')->setMaxResults(3);
        $blog = $qb->getQuery()->getResult();

        $view = new ViewModel();;
        $view->gallery = $gallery;
        $view->blog = $blog;
        //by default we are going to get the contents for home
        $view->content = $this->getContent('home');

        return $view;
    }

    //default sitemap
    public function sitemapAction(){
        $view = new ViewModel();
        $view->content = $this->getContent('sitemap');
        return $view;
    }

    //default sitemap xml
    public function sitemapXmlAction(){

        //create view
        $view = new ViewModel();
        $view->setTemplate('delamatre-zend-cms/index/sitemap-xml.phtml');
        $view->setTerminal(true);

        //create response
        $response = new \Zend\Http\Response();
        $response->getHeaders()->addHeaderLine('Content-Type', 'text/xml; charset=utf-8');

        //render view in response
        $viewRender = $this->getServiceLocator()->get('ViewRenderer');
        $response->setContent($viewRender->render($view));

        //return the response
        return $response;
    }

    //default contact page
    public function contactAction(){

        $view = new ViewModel();
        $view->content = $this->getContent('contact');
        $view->isXmlHttpRequest = $this->getRequest()->isXmlHttpRequest();
        //$view->setTerminal($view->isXmlHttpRequest);
        return $view;
    }

    //default lead thank you
    public function thankYouAction(){

        $view = new ViewModel();
        $view->content = $this->getContent('thank-you');
        $view->isXmlHttpRequest = $this->getRequest()->isXmlHttpRequest();
        return $view;
    }

}
