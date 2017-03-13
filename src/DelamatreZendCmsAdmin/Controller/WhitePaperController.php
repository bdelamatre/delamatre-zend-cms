<?php

namespace DelamatreZendCmsAdmin\Controller;

use DelamatreZendCmsAdmin\Mvc\Controller\AbstractEntityAdminController;

class WhitePaperController extends AbstractEntityAdminController
{

    public $routeName = 'white-paper';
    public $entityName = 'Application\Entity\WhitePaper';
    public $formName = 'DelamatreZendCmsAdmin\Form\WhitePaperForm';

}
