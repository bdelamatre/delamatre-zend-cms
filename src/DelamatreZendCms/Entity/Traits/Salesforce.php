<?php

namespace DelamatreZendCms\Entity\Traits;

trait Salesforce{

    /**
     * @ORM\Column(type="boolean")
     */
    public $sent_to_salesforce = 0;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $salesforce_object_id;

    /*
     * return array
     */
    public static function getSalesforceMapping(){
        return array();
    }

    public function getSalesforceFields($implode=false){
        $mapping = $this->getSalesforceMapping();
        foreach ($mapping as $key=>$item) {
            //skip sub fields
            /*if(strstr($key,'.')){
                unset($mapping[$key]);
            }*/
        }
        $fields = array_keys($mapping);
        if($implode==false){
            return $fields;
        }else{
            return implode($implode,$fields);
        }
    }

    public function exchangeToSalesforceObject($salesforceObject,$object=null,$mapping=null){

        if(is_null($mapping)){
            $mapping = $this->getSalesforceMapping();
        }

        if(is_null($object)){
            $object = $this;
        }

        //map the id
        $salesforceObject->Id = $object->salesforce_object_id;

        foreach($mapping as $salesforceField=>$thisField){

            if($thisField==false){
                continue;
            }elseif(strstr($salesforceField,'.')){
                continue;
            }

            $salesforceObject->{$salesforceField} = $object->{$thisField};
        }

        return $salesforceObject;
    }

}
