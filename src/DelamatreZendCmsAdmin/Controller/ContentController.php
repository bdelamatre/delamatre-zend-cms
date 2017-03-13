<?php

namespace DelamatreZendCmsAdmin\Controller;

use DelamatreZendCmsAdmin\Mvc\Controller\AbstractEntityAdminController;

class ContentController extends AbstractEntityAdminController
{

    public $routeName = 'content';
    public $entityName = 'DelamatreZendCms\Entity\Content';
    public $formName = 'DelamatreZendCmsAdmin\Form\ContentForm';

}
