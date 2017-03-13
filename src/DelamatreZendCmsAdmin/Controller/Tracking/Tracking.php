<?php

/**
 * Class Tracking
 */
class Tracking
{

    public function begin(){
        $this->addUtmParametersToSession();
    }

    public function addUtmParametersToSession()
    {

        //grab Urchin information and persist it in the session
        //fix-me: use zend session class
        if (isset($_GET['utm_source'])) {
            $utm_source = $_GET['utm_source'];
        } else {
            $utm_source = null;
        }

        if (isset($_GET['utm_medium'])) {
            $utm_medium = $_GET['utm_medium'];
        } else {
            $utm_medium = null;
        }

        if (isset($_GET['utm_campaign'])) {
            $utm_campaign = $_GET['utm_campaign'];
        } else {
            $utm_campaign = null;
        }

        if (!empty($utm_source)) {
            $_SESSION['utm_source'] = $utm_source;
            if(isset($_SERVER['HTTP_REFERER'])){
                $_SESSION['utm_referral_url'] = $_SERVER['HTTP_REFERER'];
            }
        }

        if (!empty($utm_medium)) {
            $_SESSION['utm_medium'] = $utm_medium;
            if(isset($_SERVER['HTTP_REFERER'])){
                $_SESSION['utm_referral_url'] = $_SERVER['HTTP_REFERER'];
            }
        }

        if (!empty($utm_campaign)) {
            $_SESSION['utm_campaign'] = $utm_campaign;
            if(isset($_SERVER['HTTP_REFERER'])){
                $_SESSION['utm_referral_url'] = $_SERVER['HTTP_REFERER'];
            }
        }

    }

    public function getUtmSource(){
        if(isset($_SESSION['utm_source'])){
            return $_SESSION['utm_source'];
        }else{
            return null;
        }
    }

    public function getUtmMedium(){
        if(isset($_SESSION['utm_medium'])){
            return $_SESSION['utm_medium'];
        }else{
            return null;
        }
    }

    public function getUtmCampaign(){
        if(isset($_SESSION['utm_campaign'])){
            return $_SESSION['utm_campaign'];
        }else{
            return null;
        }
    }

    public function getUtmReferralUrl(){
    if(isset($_SESSION['utm_referral_url'])){
        return $_SESSION['utm_referral_url'];
    }else{
        return null;
    }
}


    public function getIpAddress(){

        if(getenv('HTTP_CLIENT_IP')) {
            $ip_address = getenv('HTTP_CLIENT_IP');
        }elseif(getenv('HTTP_X_FORWARDED_FOR')) {
            $ip_address = getenv('HTTP_X_FORWARDED_FOR');
        }elseif(getenv('HTTP_X_FORWARDED')) {
            $ip_address = getenv('HTTP_X_FORWARDED');
        }elseif(getenv('HTTP_FORWARDED_FOR')) {
            $ip_address = getenv('HTTP_FORWARDED_FOR');
        }elseif(getenv('HTTP_FORWARDED')) {
            $ip_address = getenv('HTTP_FORWARDED');
        }elseif(getenv('REMOTE_ADDR')) {
            $ip_address = getenv('REMOTE_ADDR');
        }else {
            $ip_address = false;
        }

        return $ip_address;

    }

    public function getSessionId(){
        return session_id();
    }

    public function getVisitedUrl(){
        return $_SERVER['REQUEST_URI'];
    }

    public function getReferralUrl(){
        return $_SERVER['HTTP_REFERER'];
    }

}