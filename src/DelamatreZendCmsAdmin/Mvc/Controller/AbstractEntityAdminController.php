<?php

namespace DelamatreZendCmsAdmin\Mvc\Controller;

use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class AbstractEntityAdminController extends AbstractAdminActionController
{

    public $routeName = 'entity';
    public $entityName = 'DelamatreZendCms\Entity\Superclass\Content';
    public $formName = 'DelamatreZend\Form\Form';
    public $requiredGroups = array('user','admin','superadmin');

    public function buildQuery(){

        $qb = $this->createQueryBuilder();
        $qb->select(array('u'))
            ->from($this->entityName,'u')
            ->orderBy('u.active', 'DESC')
            ->addOrderBy('u.title', 'ASC');
        return $qb;
    }


    public function indexAction(){

        //require authentication
        $this->requireAuthentication($this->requiredGroups);


        //start building the users query
        $qb = $this->buildQuery();
        $records = $qb->getQuery()->getResult();
        $recordCount = count($records);

        $view = new ViewModel();
        $view->recordCount = $recordCount;
        $view->records = $records;
        $view->formName = $this->formName;
        $view->entityName = $this->entityName;
        $view->routeName = $this->routeName;
        return $view;

    }

    public function crudBusinessRules(\DelamatreZendCms\Entity\Superclass\Content $entity){

        if(!$entity->created_datetime){
            $entity->created_datetime = new \DateTime('now');
        }

        $entity->updated_datetime = new \DateTime('now');

    }

    public function formAction(){

        $this->requireAuthentication($this->requiredGroups);

        $id = $this->params()->fromQuery('id');

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

        //if this is a post than add the post to the lead
        if($this->getRequest()->isPost()){

            $post = $this->params()->fromPost();

            $entity->exchangeArray($post);

            $this->crudBusinessRules($entity);

            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();

            $this->redirect()->toUrl('/admin/'.$this->routeName.'/form?id='.$entity->id);

        }

        $formName = $this->formName;

        $form = new $formName('form',array('entityManager'=>$this->getEntityManager()));

        $data = $entity->getArrayCopy();
        $form->setData($data);

        $view = new ViewModel();
        $view->id = $id;
        $view->form = $form;
        $view->formName = $this->formName;
        $view->entity = $entity;
        $view->entityName = $this->entityName;
        $view->routeName = $this->routeName;
        $view->defaultTab = $this->params()->fromQuery('default-tab',false);
        return $view;

    }

    public function deactivateAction(){

        $this->requireAuthentication($this->requiredGroups);

        $id = $this->params()->fromQuery('id');

        //if an id is specific get that lead, else create a new lead
        if(empty($id)){
            throw new \Exception('No id specified');
        }else{

            /** @var \DelamatreZendCms\Entity\Superclass\Content $entity */
            $entity = $this->getEntityManager()->find($this->entityName,$id);

            if(empty($entity)){
                throw new \Exception('No '.$this->entityName.' found for id '.$id);
            }

            $entity->active = false;
            $this->getEntityManager()->flush();

            $this->redirect()->toUrl('/admin/'.$this->routeName.'/form?id='.$entity->id);

        }

    }

    public function activateAction(){

        $this->requireAuthentication($this->requiredGroups);

        $id = $this->params()->fromQuery('id');

        //if an id is specific get that lead, else create a new lead
        if(empty($id)){
            throw new \Exception('No id specified');
        }else{

            /** @var \DelamatreZendCms\Entity\Superclass\Content $entity */
            $entity = $this->getEntityManager()->find($this->entityName,$id);

            if(empty($entity)){
                throw new \Exception('No '.$this->entityName.' found for id '.$id);
            }

            $entity->active = true;
            $this->getEntityManager()->flush();

            $this->redirect()->toUrl('/admin/'.$this->routeName.'/form?id='.$entity->id);

        }

    }

    public function duplicateAction(){

        $this->requireAuthentication($this->requiredGroups);

        $id = $this->params()->fromQuery('id');

        //if an id is specific get that lead, else create a new lead
        if(empty($id)){
            throw new \Exception('No id specified');
        }else{

            /** @var \DelamatreZendCms\Entity\Superclass\Content $entity */
            $entity = $this->getEntityManager()->find($this->entityName,$id);

            if(empty($entity)){
                throw new \Exception('No '.$this->entityName.' found for id '.$id);
            }

            //duplicate entity
            /** @var \DelamatreZendCms\Entity\Superclass\Content $newEntity */
            $newEntity = clone $entity;
            $newEntity->key = $newEntity->key.'-copy';
            $this->getEntityManager()->persist($newEntity);
            $this->getEntityManager()->flush();

            $this->redirect()->toUrl('/admin/'.$this->routeName.'/form?id='.$newEntity->id);

        }

    }

    public function deleteAction(){

        $this->requireAuthentication($this->requiredGroups);

        $id = $this->params()->fromQuery('id');

        //if an id is specific get that lead, else create a new lead
        if(empty($id)){
            throw new \Exception('No id specified');
        }else{

            /** @var \DelamatreZendCms\Entity\Superclass\Content $entity */
            $entity = $this->getEntityManager()->find($this->entityName,$id);

            if(empty($entity)){
                throw new \Exception('No '.$this->entityName.' found for id '.$id);
            }

            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();

            $this->redirect()->toUrl('/admin/'.$this->routeName.'/index');

        }

    }

}
