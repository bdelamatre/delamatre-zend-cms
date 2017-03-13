<?php

namespace DelamatreZendCmsAdmin\Controller;

use DelamatreZendCmsAdmin\Mvc\Controller\AbstractEntityAdminController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractEntityAdminController
{

    public function indexAction(){

        $this->requireAuthentication(array('user','admin','superadmin'));

        $blogQuery = $this->createQueryBuilder();
        $blogQuery->select($blogQuery->expr()->count('e.id'))->from('DelamatreZendCms\Entity\Blog','e');
        $blogCount = $blogQuery->getQuery()->getSingleScalarResult();

        $caseStudyQuery = $this->createQueryBuilder();
        $caseStudyQuery->select($caseStudyQuery->expr()->count('e.id'))->from('DelamatreZendCms\Entity\CaseStudy','e');
        $caseStudyCount = $caseStudyQuery->getQuery()->getSingleScalarResult();

        $contentQuery = $this->createQueryBuilder();
        $contentQuery->select($contentQuery->expr()->count('e.id'))->from('DelamatreZendCms\Entity\Content','e');
        $contentCount = $contentQuery->getQuery()->getSingleScalarResult();

        $documentQuery = $this->createQueryBuilder();
        $documentQuery->select($documentQuery->expr()->count('e.id'))->from('DelamatreZendCms\Entity\Document','e');
        $documentCount = $documentQuery->getQuery()->getSingleScalarResult();

        $galleryQuery = $this->createQueryBuilder();
        $galleryQuery->select($galleryQuery->expr()->count('e.id'))->from('DelamatreZendCms\Entity\Gallery','e');
        $galleryCount = $galleryQuery->getQuery()->getSingleScalarResult();

        $videoQuery = $this->createQueryBuilder();
        $videoQuery->select($videoQuery->expr()->count('e.id'))->from('DelamatreZendCms\Entity\Video','e');
        $videoCount = $videoQuery->getQuery()->getSingleScalarResult();

        $whitePaperQuery = $this->createQueryBuilder();
        $whitePaperQuery->select($whitePaperQuery->expr()->count('e.id'))->from('DelamatreZendCms\Entity\WhitePaper','e');
        $whitePaperCount = $whitePaperQuery->getQuery()->getSingleScalarResult();

        $userQuery = $this->createQueryBuilder();
        $userQuery->select($userQuery->expr()->count('e.id'))->from($this->getUserClass(),'e');
        $userCount = $userQuery->getQuery()->getSingleScalarResult();

        $organizationQuery = $this->createQueryBuilder();
        $organizationQuery->select($organizationQuery->expr()->count('e.id'))->from($this->getOrganizationClass(),'e');
        $organizationCount = $organizationQuery->getQuery()->getSingleScalarResult();

        $view = new ViewModel();
        $view->blogCount = $blogCount;
        $view->caseStudyCount = $caseStudyCount;
        $view->contentCount = $contentCount;
        $view->documentCount = $documentCount;
        $view->galleryCount = $galleryCount;
        $view->videoCount = $videoCount;
        $view->whitePaperCount = $whitePaperCount;
        $view->userCount = $userCount;
        $view->organizationCount = $organizationCount;
        return $view;
    }

    public function referenceAction(){

        $this->requireAuthentication(array('user','admin','superadmin'));

        $config = $this->getServiceLocator()->get('config');
        $routes = $config['router']['routes'];

        foreach($routes as $name=>$route){
            if(strstr($name,'old-')
                || strstr($name,'getavulcan-')){
                unset($routes[$name]);
            }
        }

        $view = new ViewModel();
        $view->routes = $routes;
        return $view;
    }

}
