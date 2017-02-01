<?php

namespace DelamatreZendCms\Entity;

use DelamatreZend\Entity\AbstractEntity;
use DelamatreZendCms\Entity\Traits\Salesforce;
use DelamatreZendCms\Entity\Traits\Tracking;
use DelamatreZendCms\Form\Element\Country;
use DelamatreZendCms\Form\LeadForm;
use DelamatreZendCmsAdmin\Form\Getresponse;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use Zend\Validator\Timezone;

/**
 * @ORM\Table(name="lead")
 */
class Lead extends AbstractEntity{

    use Tracking;
    use Salesforce;
    //use Getresponse;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $access_id;

    /**
     * @ORM\Column(type="datetime")
     */
    public $created_timestamp;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $created_by;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $owner;

    /**
     * @ORM\Column(type="string")
     */
    public $first_name;

    /**
     * @ORM\Column(type="string")
     */
    public $last_name;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $email;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $website;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    public $description;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $company;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $phone;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $street;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $city;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $state;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $postal_code;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $country;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $continent;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $timezone;

    /**
     * @ORM\Column(type="float",nullable=true)
     */
    public $latitude = 0.0;

    /**
     * @ORM\Column(type="float",nullable=true)
     */
    public $longitude = 0.0;


    /**
     * Suggestions of available UTM Source values for tracking the lead (when manually entering)
     *
     * @var array
     */
    public static $utmSourceSuggestions = array(
        'cold-call' => 'cold call',
        'direct-email' => 'direct email',
        'web-referral'=>'web-referral',
        'trade-show'=>'trade-show',
    );

    /**
     * Default mapping of Entity\Lead fields to Salesforce API fields. Please note, you will need to add the custom tracking fields to your SalesForce implementation (below).
     *
     * The following custom fields need to be added to your SalesForce implementation:
     *      Description__c
     *      Application__c
     *      Division__c
     *      UTM_Campaign__c
     *      UTM_Medium__c
     *      UTM_Source__c
     *      UTM_Referral_URL__c
     *      Referral_URL__c
     *      Visited_URL__c
     *      IP_Address__c
     *      TimeZone__c
     *      LeadDashboardURL__c
     *
     * @return array
     */
    public function getSalesforceMapping(){
        return array(
            'Owner.Id' => 'owner',
            'Owner.Alias' => 'ownerAlias',
            'Status' => false,
            'FirstName' => 'first_name',
            'LastName' => 'last_name',
            'Company' => 'company',
            'Email' => 'email',
            'Phone' => 'phone',
            'Website' => 'website',
            'Street' => 'street',
            'City' => 'city',
            'State' => 'state',
            'PostalCode' => 'postal_code',
            'Country' => 'country',
            'Industry' => 'industry',
            'LeadSource' => false,
            //custom fields
            'Description__c' => 'description',
            'Application__c' => 'application',
            'Division__c' => 'tracking_division',
            'UTM_Campaign__c' => 'tracking_utm_campaign',
            'UTM_Medium__c' => 'tracking_utm_medium',
            'UTM_Source__c' => 'tracking_utm_source',
            'UTM_Referral_URL__c' => 'tracking_utm_referral_url',
            'Referral_URL__c' => 'tracking_referral_url',
            'Visited_URL__c' => 'tracking_visited_url',
            'IP_Address__c' => 'tracking_ip_address',
            'TimeZone__c' => 'tracking_timezone',
            'LeadDashboardURL__c' => false,
        );

    }

    /**
     * Generate a unique and randome access ID for this lead that can be used to acccess without authentication.
     *
     * @param EntityManager $entityManager
     * @param bool $overwrite
     * @return mixed
     */
    public function generateAccessId(EntityManager $entityManager,$overwrite=false){

        if($this->access_id && $overwrite==false){
            return $this->access_id;
        }

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 32; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        //make sure that the access id doesn't already exist
        $existingQb = $entityManager->createQueryBuilder();
        $existingQb->select('l')->from(get_class($this),'l')->where('l.access_id = :access_id');

        $query = $existingQb->getQuery()->setParameter('access_id',$randomString);

        $result = $query->execute();

        if(!empty($result)){
            $this->generateAccessId($entityManager, $overwrite);
        }else{
            $this->access_id = $randomString;
        }

    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function exchangeArray(array $data)
    {

        //convert a text timestamp to a \DateTime timestamp
        if(isset($data['created_timestamp'])){
            $data['created_timestamp'] = new \DateTime($data['created_timestamp']);
        }

        //determine and set the continent based on the country
        if(isset($data['country'])){
            $this->setContinentFromCountryCode($data['country']);
        }

        //determine and set additional tracking information based on the tracking country
        if(isset($data['tracking_country_code'])){
            $this->setTrackingCountryInfoFromCountryCode($data['tracking_country_code']);
        }

        parent::exchangeArray($data);
    }

    public function setCreatedToNow(){
        $this->created_timestamp = new \DateTime('now');
    }

    public function setCreatedBy($username){
        $this->created_by = $username;
    }

    public function setContinentFromCountryCode($countryCode){
        $info = Country::options()[$countryCode];
        $this->continent = $info['continent'];
    }

    public function getLeadDashboardUrl($baseUrl){
        return $baseUrl.'/admin/lead/dashboard?id='.$this->id.'&access_id='.$this->access_id;
    }

    public function hasHistory(){
        if($this->tracking_session_id){
            return true;
        }else{
            return false;
        }
    }

    public function hasGeoIp(){
        if($this->tracking_ip_address){
            return true;
        }else{
            return false;
        }
    }

    public function sendToSalesForceApi(\SforceEnterpriseClient $client,$baseUrl='https://www.vulcansystems.com',EntityManager $entityManager = null, array $getresponseClients = array()){

        //build salesforce object
        $sObject = new \stdClass();

        //map known fields to salesforce object
        $this->exchangeToSalesforceObject($sObject);

        //map additional fields to salesforce object
        $sObject->OwnerId = $this->owner;
        $sObject->LeadSource = self::utmMediumToSalesForceLeadSource($this->tracking_utm_medium);
        $sObject->Division__c = $this->getTrackingDivision();
        $sObject->LeadDashboardURL__c = $this->getLeadDashboardUrl($baseUrl);
        $sObject->Has_History__c = $this->hasHistory();
        if($entityManager){
            $sObject->Has_Roi_Calculation__c = $this->hasRoiCalculation($entityManager);
        }
        $sObject->Has_GeoIP__c = $this->hasGeoIp();


        if(!empty($getresponseClients)){

            $inGetresponse = false;

            //cycle through all getresponse accounts
            foreach($getresponseClients as $account=>$getresponseClient){

                if($inGetresponse==true){
                    continue;
                }

                //check this account for any contacts with this e-mail address
                $result = (array)$getresponseClient->getContacts(array(
                    'query' => array(
                        'email' => $this->email,
                    ),
                    'fields' => 'id'
                ));

                foreach($result as $record){

                    $inGetresponse = true;

                }

            }

            $sObject->Has_Getresponse__c = $inGetresponse;

        }

        //fix-me: how to handle an error
        $createResponse = $client->upsert('Id', array($sObject), 'Lead');

        $errors = array();
        $ids = array();
        foreach ($createResponse as $createResult){
            //if($createResult['errors']){
                $errors = array_merge($errors,$createResult->errors);
            //}else{
                array_push($ids, $createResult->id);
            //}
        }

        if(empty($errors)){
            $this->sent_to_salesforce = true;
            $this->salesforce_object_id = $ids[0];
            return $this->salesforce_object_id;
        }else{
            $e = new \Exception($errors[0]->message);
            throw $e;
        }

    }

    public function getOwner(\SforceEnterpriseClient $client=null){
        if(!$this->owner){
            return 'Unassigned';
        }else{

            if($client){

                $response = $client->query("SELECT Id, Name FROM User WHERE Id = '{$this->owner}'");

                return $response->records[0]->Name;

            }

            return $this->owner;
        }
    }

    public function getEmailDomain(){
        list($name,$domain) = explode('@',$this->email);
        return $domain;
    }

    /**
     * @return LeadForm
     */
    public function getForm(){

        $form = new LeadForm();

        return $form;
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }


        return $this->inputFilter;
    }

}
