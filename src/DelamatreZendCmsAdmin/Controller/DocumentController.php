<?php

namespace DelamatreZendCmsAdmin\Controller;

use DelamatreZendCmsAdmin\Mvc\Controller\AbstractEntityAdminController;

class DocumentController extends AbstractEntityAdminController
{

    public $routeName = 'document';
    public $entityName = 'Application\Entity\Document';
    public $formName = 'DelamatreZendCmsAdmin\Form\DocumentForm';

    public function buildQuery()
    {

        $category = $this->params()->fromQuery('category');

        $qb = parent::buildQuery();
        $qb->orderBy('u.active','DESC');
        $qb->addOrderBy('u.category','ASC');
        $qb->addOrderBy('u.title','ASC');

        if($category){
            $qb->andWhere('u.category=:category');
            $qb->setParameter('category',$category);
        }

        return $qb;
    }

    public function downloadAllAction(){

        //create zip file
        $filename = 'vulcan_all_documents.zip';
        $filenameandpath = 'data/cache/'.$filename;
        unlink($filenameandpath);
        $zip = new \ZipArchive();
        if ($zip->open($filenameandpath, \ZipArchive::CREATE)!==TRUE) {
            exit("cannot open <$filenameandpath>\n");
        }

        //get all documents
        $documentQuery = $this->createQueryBuilder();
        $documentQuery->select('d')
            ->from($this->entityName,'d');
        $documents = $documentQuery->getQuery()->getResult();

        /* @var \Application\Entity\Document $document */
        foreach($documents as $document){
            //echo 'public'.$document->getDownload().'<br/>';
            $zip->addFile('public'.$document->getDownload(),basename($document->getDownload()));

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

}
