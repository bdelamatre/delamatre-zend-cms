<?php

namespace DelamatreZendCmsAdmin\Controller;

use DelamatreZendCmsAdmin\Mvc\Controller\AbstractEntityAdminController;

class CaseStudyController extends AbstractEntityAdminController
{

    public $routeName = 'case-study';
    public $entityName = 'Application\Entity\CaseStudy';
    public $formName = 'DelamatreZendCmsAdmin\Form\CaseStudyForm';

}
