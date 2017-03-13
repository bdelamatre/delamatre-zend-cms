<?php

namespace DelamatreZendCmsAdmin\Controller;


use DelamatreZendCms\Entity\EmailTemplate;
use DelamatreZendCmsAdmin\Mvc\Controller\AbstractEntityAdminController;

class EmailTemplateController extends AbstractEntityAdminController
{

    public $routeName = 'email-template';
    public $entityName = 'DelamatreZendCms\Entity\EmailTemplate';
    public $formName = 'DelamatreZendCmsAdmin\Form\EmailTemplateForm';

    public function previewAction(){

        $this->requireAuthentication(array('user','admin','superadmin'));

        $id = $this->params()->fromQuery('id');

        /* @var EmailTemplate $entity */
        //if an id is specific get that lead, else create a new lead
        if(empty($id)){
            $entity = new $this->entityName();
        }else{

            /** @var \DelamatreZendCms\Entity\Blog $blog */
            $entity = $this->getEntityManager()->find($this->entityName,$id);

            if(empty($entity)){
                throw new \Exception('No '.$this->entityName.' found for id '.$id);
            }
        }

        echo $entity->generateHtml();
        exit();

    }


}
