<?php

namespace DelamatreZendCmsAdmin\Controller;

use DelamatreZendCmsAdmin\Mvc\Controller\AbstractEntityAdminController;
use Zend\View\Model\ViewModel;

class HelpController extends AbstractEntityAdminController
{

    public function contentAction(){

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


    public function feelTheMagicAction(){

        $doneFeelingTheMagic = $this->params()->fromQuery('done');

        if($doneFeelingTheMagic==true){
            $_SESSION['feelthemagic'] = false;
        }else{
            $_SESSION['feelthemagic'] = true;
        }

        $this->redirect()->toUrl('/admin');

    }

}
