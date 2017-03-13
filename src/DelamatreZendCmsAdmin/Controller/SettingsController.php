<?php

namespace DelamatreZendCmsAdmin\Controller;

use DelamatreZendCmsAdmin\Mvc\Controller\AbstractEntityAdminController;
use Zend\View\Model\ViewModel;

class SettingsController extends AbstractEntityAdminController
{

    public function configurationAction(){

        $this->requireAuthentication(array('superadmin'));

        $section = $this->params()->fromQuery('section',false);
        if($section){
            $config = $this->getConfig()[$section];
        }else{
            $config = $this->getConfig();
        }

        $view = new ViewModel();
        $view->config = $config;
        $view->section = $section;
        return $view;
    }

    public function phpinfoAction(){

        $this->requireAuthentication(array('superadmin'));

        echo phpinfo();

    }

    public function logsAction(){

        $this->requireAuthentication(array('superadmin'));

        $logFiles = array();

        $download = $this->params()->fromQuery('download',false);
        $read = $this->params()->fromQuery('read',false);
        $clear = $this->params()->fromQuery('clear',false);
        $content = 'select a file to view its contents';

        foreach(glob('data/log/*.log')as $filename){
            $logFiles[] = $filename;
            if($download==$filename){
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($filename).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filename));
                readfile($filename);
                exit;
            }elseif($clear==$filename){
                unlink($filename);
                touch($filename);
                //we redirect here so that a page reload doesn't reclear the log
                $this->redirect()->toUrl('/admin/settings/logs?read='.$read);
            }elseif($read==$filename){
                $content = file_get_contents($filename);
            }
        }

        $view = new ViewModel();
        $view->logFiles = $logFiles;
        $view->content = $content;
        $view->read = $read;
        return $view;

    }

}
