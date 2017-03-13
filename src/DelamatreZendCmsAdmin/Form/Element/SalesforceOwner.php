<?php

namespace DelamatreZendCmsAdmin\Form\Element;

use Zend\Form\Element\Select;

class SalesforceOwner extends Select{


    public function __construct($name=null,\SforceEnterpriseClient $salesforceClient, $options=array()){

        parent::__construct($name,$options);

        $users = array(''=>'');

        //query users from sales
        $response = $salesforceClient->query("SELECT Id, Name, UserType FROM User WHERE IsActive=true AND USerType='Standard' ORDER BY Username ASC");

        foreach($response->records as $record){
            $users[$record->Id] = $record->Name;
        }

        $this->setValueOptions($users);
        $this->setLabel('Salesforce Owner');

    }

}