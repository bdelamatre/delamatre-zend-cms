<?php

namespace DelamatreZendCms\Entity\Traits;

use DelamatreZendCms\Form\Element\Country;
use GeoIp2\WebService\Client;

trait Tracking{

    public static $HONEY_POT_FIELD = 'url';

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_session_id;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    public $tracking_duplicate=0;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    public $tracking_spam=0;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_division;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_utm_source;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_utm_medium;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_utm_campaign;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    public $tracking_utm_referral_url;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    public $tracking_visited_url;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    public $tracking_referral_url;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_ip_address;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_host_name;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_ip_organization;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_ip_isp;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_ip_asn;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_ip_asn_organization;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    public $tracking_continent;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_country_code;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_country_name;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_state_code;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_state_name;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_city_name;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $tracking_postal_code;

    /**
     * @ORM\Column(type="float",nullable=true)
     */
    public $tracking_latitude = 0.0;

    /**
     * @ORM\Column(type="float",nullable=true)
     */

    public $tracking_longitude = 0.0;

    /**
     * @ORM\Column(type="string",nullable=true)
     */

    public $tracking_timezone;


    public function setTrackingInformation(Client $client){
        $this->setTrackingSessionIdFromSession();
        $this->setTrackingUtmFromSession();
        $this->setTrackingIpAddress();
        $this->setTrackingGeoIpInfoFromClient($client);
        $this->setTrackingHostName();
    }

    public function setTrackingSessionIdFromSession(){

        $this->tracking_session_id = session_id();
    }

    public function setTrackingUtmFromSession(){

        $this->tracking_utm_source       = $_SESSION['utm_source'];
        $this->tracking_utm_medium       = $_SESSION['utm_medium'];
        $this->tracking_utm_campaign     = $_SESSION['utm_campaign'];
        $this->tracking_utm_referral_url = $_SESSION['utm_referral_url'];
    }

    public function setTrackingIpAddress(){

        if (getenv('HTTP_CLIENT_IP'))
            $ip_address = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ip_address = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ip_address = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ip_address = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ip_address = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ip_address = getenv('REMOTE_ADDR');
        else
            $ip_address = 'UNKNOWN';

        $this->tracking_ip_address = $ip_address;

        return $this->tracking_ip_address;
    }

    public function setTrackingHostName(){

        $host_name = gethostbyaddr($this->tracking_ip_address);
        $this->tracking_host_name = $host_name;
    }


    public function setTrackingGeoIpInfoFromClient(Client $client,$ip_address=null,$set_ip_address=false){

        if($set_ip_address==true){
            $this->setTrackingIpAddress();
        }

        if(is_null($ip_address)){
            $ip_address = $this->tracking_ip_address;
        }

        try{

            $city = $client->city($ip_address);
            $this->setTrackingGeoIpInfo($city);
            return $city;

        }catch(\Exception $e){

            //silence any exceptions

        }

    }


    /**
     * @param \GeoIp2\Record\City $geoIp2Record
     */
    public function setTrackingGeoIpInfo($cityRecord){

        $this->tracking_ip_organization  = $cityRecord->traits->organization;
        $this->tracking_ip_isp           = $cityRecord->traits->isp;
        $this->tracking_ip_asn           = $cityRecord->traits->autonomousSystemNumber;

        $this->setTrackingCountryInfoFromCountryCode($cityRecord->country->isoCode);
        $this->tracking_state_code       = $cityRecord->mostSpecificSubdivision->isoCode;
        $this->tracking_state_name       = $cityRecord->mostSpecificSubdivision->name;
        $this->tracking_city_name        = $cityRecord->city->name;
        $this->tracking_postal_code      = $cityRecord->postal->code;
        $this->tracking_latitude         = $cityRecord->location->latitude;
        $this->tracking_longitude        = $cityRecord->location->longitude;
        $this->tracking_timezone         = $cityRecord->location->timeZone;

    }

    public function setTrackingCountryInfoFromCountryCode($countryCode){
        $info = Country::options()[$countryCode];
        $this->tracking_country_code = $countryCode;
        $this->tracking_country_name = $info['country'];
        $this->tracking_continent = $info['continent'];
    }

    public function checkifSpam($post,$autoset=true){

        $isSpam = false;

        if(isset($post[self::$HONEY_POT_FIELD]) && !empty($post[self::$HONEY_POT_FIELD])){
            $isSpam = true;
        }

        if($autoset==true){
            $this->tracking_spam = $isSpam;
        }

        return $isSpam;
    }

    public static function utmMediumToSalesForceLeadSource($utmMedium){

        switch($utmMedium){
            case 'eblast':
                return 'E-blast';
            case 'cpc':
                return 'Paid Search';
            case 'social':
                return 'Social Media';
            default:
                return 'Website';
        }

    }

    public function getTrackingDivision($defaultDivision='Vulcan'){
        if($this->tracking_division){
            return $this->tracking_division;
        }else{
            return $defaultDivision;
        }
    }

    public function getLocalTimeOffset($timezone=null){

        if(is_null($timezone)){
            $timezone = new \DateTimeZone($this->tracking_timezone);
        }

        if($timezone){
            return $timezone->getOffset(new \DateTime('now'));
        }else{
            $timezone = new \DateTimeZone(date_default_timezone_get());
            return $timezone->getOffset(new \DateTime('now'));
        }

    }

    public function getLocalTime($timezone=null){

        if(is_null($timezone)){
            $timezone = $this->tracking_timezone;
        }

        if($timezone){
            $datetime = new \DateTime('now',new \DateTimeZone($timezone));
            return $datetime;
        }else{
            $datetime = new \DateTime('now',new \DateTimeZone(date_default_timezone_get()));
            return $datetime;
        }


    }

}
