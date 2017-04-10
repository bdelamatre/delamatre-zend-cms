<?php

namespace DelamatreZendCms\Form;

use DelamatreZendCms\Form\Element\Country;
use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Form;

class LeadForm extends Form{

    /**
     * @var CaptchaAdapter
     */
    protected $captcha;

    public function __construct($name=null, $options=array(), \SforceEnterpriseClient $client=null){

        if(isset($options['captcha_adapter'])){
            $this->captcha = $options['captcha_adapter'];
        }

        parent::__construct($name);

        $this->add(array(
            'name' => 'first_name',
            'type' => 'text',
            'options' => array(
                'label' => 'First Name',
                'required' => true,
            ),
            'attributes' => array(
                'required' => true,
            ),
        ));

        $this->add(array(
            'name' => 'last_name',
            'type' => 'text',
            'options' => array(
                'label' => 'Last Name',
                'required' => true,
            ),
            'attributes' => array(
                'required' => true,
            ),
        ));

        $this->add(array(
            'name' => 'company',
            'type' => 'text',
            'options' => array(
                'label' => 'Company',
                'required' => true,
            ),
            'attributes' => array(
                'required' => true,
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'type' => 'email',
            'options' => array(
                'label' => 'E-Mail',
                'required' => true,
            ),
            'attributes' => array(
                'placeholder' => 'john.doe@gmail.com',
                'required' => true,
            ),
        ));

        $this->add(array(
            'name' => 'phone',
            'type' => 'text',
            'options' => array(
                'label' => 'Phone',
                'required' => true,
            ),
            'attributes' => array(
                'required' => true,
                'placeholder' => '+1 (234) 567-8901',
            ),
        ));

        $this->add(array(
            'name' => 'street',
            'type' => 'text',
            'options' => array(
                'label' => 'Street',
            ),
        ));

        $this->add(array(
            'name' => 'city',
            'type' => 'text',
            'options' => array(
                'label' => 'City',
            ),
        ));

        $this->add(array(
            'name' => 'postal_code',
            'type' => 'text',
            'options' => array(
                'label' => 'Postal Code',
            ),
        ));

        $this->add(array(
            'name' => 'state',
            'type' => 'text',
            'options' => array(
                'label' => 'State',
            ),
        ));

        $country = new Country('country');
        $this->add($country);

        $this->add(array(
            'name' => 'description',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Description',
                'required' => true,
            ),
            'attributes' => array(
                'required' => true,
                'cols' => 125,
                'rows' => 10,
            ),
        ));

        $this->add(array(
            'name' => 'url',
            'type' => 'text',
            'options' => array(
                'label' => 'URL (do not fill)',
            ),
            'attributes' => array(
                'class' => 'hp',
            ),
        ));

        $this->add(array(
            'name' => 'tracking_division',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'tracking_session_id',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'tracking_visited_url',
            'type' => 'hidden',
            'options' => array(
                'label' => 'Visited URL',
            ),
        ));

        $this->add(array(
            'name' => 'tracking_referral_url',
            'type' => 'hidden',
            'options' => array(
                'label' => 'Referral URL',
            ),
        ));

        $this->add(array(
            'name' => 'tracking_utm_source',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'tracking_utm_medium',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'tracking_utm_campaign',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'tracking_utm_referral_url',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'redirect',
            'type' => 'hidden',
            'options' => array(
                'label' => 'Redirect URL',
            ),
        ));

        if($this->captcha){

            $this->add(array(
                'name' => 'captcha',
                'type' => 'captcha',
                'options' => array(
                    'label' => 'Please verify you are human.',
                    'captcha' => array(
                        'captcha' => $this->captcha,
                    ),
                ),
            ));

        }

    }

}