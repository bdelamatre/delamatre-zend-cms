<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace DelamatreZendCms\Controller;

use Application\Entity\Lead;
use DelamatreZendCms\Entity\Subscribe;
use DelamatreZendCms\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LeadController extends AbstractActionController
{

    //default submit lead
    public function submitLeadAction(){

        //get post from anywhere
        $post = $this->params()->fromPost();

        //get a new lead object based on the config file
        $lead = $this->getLeadEntity();

        //set the lead time to now
        $lead->setCreatedToNow();

        //set the lead division
        //fix-me: create function
        //$lead->setTrackingDivision($post['division'],$this->getConfig()['lead']['default_division']);
        if(empty($post['division'])){
            $post['divison'] = $this->getConfig()['lead']['default_division'];
        }

        //set the tracking information
        $lead->setTrackingInformation($this->getGeoIP2Client());

        //set values from post. do this first so that we can overwrite these values if necessary.
        $lead->exchangeArray($post);

        //generate an access id for unauthenticated access
        $lead->generateAccessId($this->getEntityManager());

        //spam detection using honeypot
        $lead->checkifSpam($post);

        $this->getEntityManager()->persist($lead);
        $this->getEntityManager()->flush();

        //send the lead to salesforce if not spam
        if($lead->tracking_spam==false
            && $this->getConfig()['salesforce']['send_leads_to_salesforce']==true){

            //$lead->sendToSalesForce($this->getConfig()['myapp']['salesforce']['web_to_lead_form']['oid']);
            $lead->sendToSalesForceApi($this->getSalesForceEnterpriseClient(),$this->getConfig()['myapp']['baseurl'],
                                        $this->getEntityManager(),$this->getGetresponseClients());

            $this->getEntityManager()->flush();
        }

        if($lead->tracking_spam==false
            && $this->getConfig()['lead']['send_to_email']){

            $message = $this->createMail();
            $message->setTo($this->getConfig()['lead']['send_to_email']);

            $lead->sendToEmail($message,$this->getSmtp());

        }

        //user has contacted us so stop bugging them with popups
        //fix-me: better way to handle this
        $_SESSION['contacted'] = true;

        //redirect to the appropriate url
        if(!empty($post['redirect'])){
            $this->redirect()->toUrl($post['redirect']);
        }else{
            $this->redirect()->toRoute('thank-you');
        }

    }

    //default lead thank you
    public function thankYouAction(){

        $view = new ViewModel();
        $view->content = $this->getContent('thank-you');
        $view->isXmlHttpRequest = $this->getRequest()->isXmlHttpRequest();
        return $view;
    }

    //default newsletter subscription
    public function submitNewsletterAction(){

        $post = $this->params()->fromPost();

        //add the lead to the local database
        //fix-me: allow overriding the subscribe object
        $subscribe = new Subscribe();

        //set created time to now
        $subscribe->setCreatedToNow();

        //add post data to the subscribe object
        $subscribe->exchangeArray($post);

        //set the tracking information for this object
        $subscribe->setTrackingInformation($this->getGeoIP2Client());

        //check if this is spam
        $subscribe->checkifSpam($post);

        $this->getEntityManager()->persist($subscribe);
        $this->getEntityManager()->flush();

        //redirect to the appropriate url
        if(!empty($post['redirect'])){
            $this->redirect()->toUrl($post['redirect']);
        }else{
            $this->redirect()->toRoute('thank-you-newsletter');
        }
    }

    //default newsletter thankyou
    public function thankYouNewsletterAction(){

        $view = new ViewModel();
        $view->content = $this->getContent('thank-you-newsletter');
        return $view;
    }

}
