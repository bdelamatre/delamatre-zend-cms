<?php

namespace DelamatreZendCmsAdmin\Form\Element;

use Zend\Form\Element\Select;

class GetresponseCampaign extends Select{


    public function __construct($name=null,array $getresponseClients=array(), $options=array()){

        parent::__construct($name,$options);

        $campaigns = array(''=>'');

        foreach($getresponseClients as $accountName=>$getresponseClient){

            //query users from sales
            $response = (array)$getresponseClient->getCampaigns();

            $accountCampaigns = array();
            foreach($response as $record){
                $accountCampaigns[$record->campaignId] = $record->name;
            }


            $campaigns[$accountName] = array(
                'label'=>$accountName,
                'options'=>$accountCampaigns,
            );

        }

        $this->setValueOptions($campaigns);
        $this->setLabel('Getresponse Campaign');

    }

}