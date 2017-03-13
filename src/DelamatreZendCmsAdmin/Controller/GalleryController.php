<?php

namespace DelamatreZendCmsAdmin\Controller;

use DelamatreZendCmsAdmin\Mvc\Controller\AbstractEntityAdminController;

class GalleryController extends AbstractEntityAdminController
{

    public $routeName = 'gallery';
    public $entityName = 'DelamatreZendCms\Entity\Gallery';
    public $formName = 'DelamatreZendCmsAdmin\Form\GalleryForm';

}
