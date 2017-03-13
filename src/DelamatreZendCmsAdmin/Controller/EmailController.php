<?php

namespace DelamatreZendCmsAdmin\Controller;


use Admin\Mvc\Controller\RelatedContent;
use Codegyre\PhantomShot\ThumbnailCollector;
use DelamatreZendCms\Entity\Email;
use DelamatreZendCmsAdmin\Form\EmailTestForm;
use DelamatreZendCmsAdmin\Mvc\Controller\AbstractEntityAdminController;
use Screen\Capture;
use Zend\View\Model\ViewModel;

class EmailController extends AbstractEntityAdminController
{

    use RelatedContent;

    public $routeName = 'email';
    public $entityName = 'DelamatreZendCms\Entity\Email';
    public $formName = 'DelamatreZendCmsAdmin\Form\EmailForm';

    public function buildQuery()
    {

        $category = $this->params()->fromQuery('category');

        $qb = parent::buildQuery();
        $qb->orderBy('u.category','ASC');
        $qb->addOrderBy('u.active','DESC');
        $qb->addOrderBy('u.subject','ASC');

        if($category){
            $qb->andWhere('u.category=:category');
            $qb->setParameter('category',$category);
        }

        return $qb;
    }

    public function screenshotAction(){

        //get the entity
        $id = $this->params()->fromQuery('id');

        /* @var Email $entity */
        $entity = $this->getEntityManager()->find($this->entityName,$id);

        if(empty($entity)){
            throw new \Exception('No '.$this->entityName.' found for id '.$id);
        }

        //make sure the save directory exists
        $saveDirectory = 'data/screenshots/emails/';

        if(!file_exists($saveDirectory)){
            mkdir($saveDirectory);
        }

        $screenCapture = new Capture();
        $screenCapture->setUrl($this->getConfig()['myapp']['baseurl'].'/admin/email/preview?id='.$id);
        $screenCapture->setImageType('png');

        //check if the screenshot already exists, if it doesn't than create it
        $filename = $saveDirectory.$id.'_'.$entity->updated_datetime->getTimestamp().'_'.$entity->emailTemplate->updated_datetime->getTimestamp().'.'.$screenCapture->getImageType()->getFormat();

        //var_dump($filename); exit();

        if(!file_exists($filename)){
            $screenCapture->save($filename);
        }

        readfile($filename);
        exit();

    }

    public function previewAction(){

        $this->requireAuthentication(array('user','admin','superadmin'));

        $id = $this->params()->fromQuery('id');

        /* @var Email $entity */
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

    public function downloadHtmlAction(){

        $this->requireAuthentication(array('user','admin','superadmin'));

        $id = $this->params()->fromQuery('id');

        /* @var Email $entity */
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

        $filename = $entity->key.'.html';

        set_time_limit(0);
        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$filename");
        //header("Content-length: " . filesize($filename));
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $entity->generateHtml();
        exit();

    }

    public function downloadAllAction(){

        $category = $this->params()->fromQuery('category');

        if($category){
            $filename = 'category_emails.zip';
        }else{
            $filename = 'all_emails.zip';
        }

            //create zip file
        $filenameandpath = 'data/cache/'.$filename;
        @unlink($filenameandpath);
        $zip = new \ZipArchive();
        if ($zip->open($filenameandpath, \ZipArchive::CREATE)!==TRUE) {
            exit("cannot open <$filenameandpath>\n");
        }

        //get all documents
        $emailQuery = $this->createQueryBuilder();
        $emailQuery->select('e')
            ->from($this->entityName,'e');

        if($category){
            $emailQuery->andWhere('e.category=:category');
            $emailQuery->setParameter('category',$category);
        }

        $emails = $emailQuery->getQuery()->getResult();

        //go through each e-mail
        /* @var \DelamatreZendCms\Entity\Email $email */
        foreach($emails as $email){

            //add that e-mails attachments to the attachment folder
            $attachments = $email->getAttachments();
            foreach($attachments as $attachment) {
                $zip->addFile($attachment, 'attachments/' . basename($attachment));
            }

            //add the e-mail template to the zip
            $zip->addFromString($email->key.'.html',$email->generateHtml(null));

        }

        $zip->close();

        set_time_limit(0);
        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$filename");
        //header("Content-length: " . filesize($filename));
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile($filenameandpath);
        exit(0);

    }

    public function sendTestAction(){

        $this->requireAuthentication(array('user','admin','superadmin'));

        $id = $this->params()->fromQuery('id');

        if(empty($id)){
            throw new \Exception("No ID specified");
        }

        /* @var Email $entity */
        $entity = $this->getEntityManager()->find($this->entityName,$id);

        if(empty($entity)){
            throw new \Exception('No '.$this->entityName.' found for id '.$id);
        }

        $form = new EmailTestForm();

        if($this->getRequest()->isPost()){

            $post = $this->params()->fromPost();
            $form->setData($post);
            if($form->isValid()){


                $message = $entity->generateMessage($this->getConfig()['myapp']['baseurl']);

                $mail = $this->createMail();
                $mail->setBody($message);
                $mail->setSubject($entity->getSubject());
                $mail->setTo($post['email'],$post['name']);

                $this->getSmtp()->send($mail);


                //send email to test recipients
                //$email = $this->getSmtp();

            }

        }


        $view = new ViewModel();
        $view->entity = $entity;
        $view->form = $form;
        return $view;

    }


}
