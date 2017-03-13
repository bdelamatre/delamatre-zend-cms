<?php

namespace DelamatreZendCmsAdmin\Form;

trait SalesforcIntegration{


    /**
     * @var \SforceEnterpriseClient
     */
    public $salesforce_client;

    public function setSalesforceClient(\SforceEnterpriseClient $client){
        $this->salesforce_client = $client;
    }

    /**
     * @return \SforceEnterpriseClient
     * @throws \Exception
     */
    public function getSalesforceClient(){

        if(!$this->salesforce_client){
            throw new \Exception("Salesforce Enterprise Client is not set on this form");
        }

        return $this->salesforce_client;
    }

    public function hasSalesforceClient(){
        if($this->salesforce_client){
            return true;
        }else{
            return false;
        }
    }

}