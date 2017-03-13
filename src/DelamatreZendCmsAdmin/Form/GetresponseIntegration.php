<?php

namespace DelamatreZendCmsAdmin\Form;

trait GetresponseIntegration{


    public $getresponse_accounts;

    /**
     * @var \GetResponse
     */
    public $getresponse_client;

    public function getGetresponseAccounts(){
        return array_keys($this->getresponse_client);
    }

    public function setGetresponseClient(\GetResponse $client, $account=null){

        if(is_null($account)){
            $account = 'default';
        }

        $this->getresponse_client[$account] = $client;
    }

    /**
     * @return \GetResponse
     * @throws \Exception
     */
    public function getGetresponseClient($account=null){

        if(is_null($account)){
            $account = current(array_keys($this->getresponse_client));
        }

        if(!$this->getresponse_client[$account]){
            throw new \Exception("Getresponse Client for $account is not set on this form");
        }

        return $this->getresponse_client;
    }

    public function hasGetresponseClient(){
        if($this->getresponse_client){
            return true;
        }else{
            return false;
        }
    }

}