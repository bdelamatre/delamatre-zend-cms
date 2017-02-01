<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace DelamatreZendCms;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        //get the event and and service manager instances
        $eventManager        = $e->getApplication()->getEventManager();
        $serviceManager      = $e->getApplication()->getServiceManager();

        //bootstrap the session
        $this->bootstrapSession($e);

    }

    public function bootstrapSession($e)
    {

        $serviceManager      = $e->getApplication()->getServiceManager();

        //fix-me: this needs to convert to a configuration
        //get the session manager
        $session = $e->getApplication()->getServiceManager()->get('Zend\Session\SessionManager');

        //start the session
        $session->start();


        //fix-me: hack to override zfcuser limitation on redirecting to urls
        if(isset($_GET['redirect'])){
            $redirect = $_GET['redirect'];
        }elseif(isset($_SESSION['redirect'])){
            $redirect = $_SESSION['redirect'];
        }else{
            $redirect = null;
        }

        $pluginManager = $serviceManager->get('ControllerPluginManager');
        $auth = $pluginManager->get('zfcUserAuthentication');
        if($auth->hasIdentity() && $redirect){
            unset($_SESSION['redirect']);
            header('Location: '.$redirect);
            exit();
        }

        //grab Urchin information and persist it in the session
        //fix-me: use zend session class
        if(isset($_GET['utm_source'])){
            $utm_source = $_GET['utm_source'];
        }else{
            $utm_source = null;
        }

        if(isset($_GET['utm_medium'])){
            $utm_medium = $_GET['utm_medium'];
        }else{
            $utm_medium = null;
        }

        if(isset($_GET['utm_campaign'])){
            $utm_campaign = $_GET['utm_campaign'];
        }else{
            $utm_campaign = null;
        }

        if(!empty($utm_source)) {
            $_SESSION['utm_source'] = $utm_source;
            $_SESSION['utm_referral_url'] = $_SERVER['HTTP_REFERER'];
        }

        if(!empty($utm_medium)){
            $_SESSION['utm_medium'] = $utm_medium;
            $_SESSION['utm_referral_url'] = $_SERVER['HTTP_REFERER'];
        }

        if(!empty($utm_campaign)){
            $_SESSION['utm_campaign'] = $utm_campaign;
            $_SESSION['utm_referral_url'] = $_SERVER['HTTP_REFERER'];
        }

    }

    public function getConfig()
    {
        $config = array();

        //split the module config into multiple files
        $configFiles = array(
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/lead.global.php',
            __DIR__ . '/config/user.global.php',
        );

        // Merge all module config options
        foreach($configFiles as $configFile) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, include $configFile);
        }

        return $config;
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
