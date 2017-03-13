<?php

namespace DelamatreZendCmsAdmin\Form;

use DelamatreZend\Form\Element\GenerateSignature;
use DelamatreZend\Form\Element\YesNo;
use DelamatreZendCmsAdmin\Form\Element\EmailTemplate;

class EmailForm extends \DelamatreZendCmsAdmin\Form\Superclass\ContentForm {

    use DoctrineIntegration;

    public function __construct($name=null,$options=array()){

        //grab the entity manager from options
        if(isset($options['entityManager'])){
            $this->setEntityManager($options['entityManager']);
        }

        if(isset($options['exclude'])){
            $exclude = $options['exclude'];
        }else{
            $exclude = array();
        }

        parent::__construct($name,$options);

        $emailTemplate = new EmailTemplate('email_template_id',array(),$this->getEntityManager());
        $this->add($emailTemplate);

        $this->add(array(
            'name' => 'subject',
            'type' => 'text',
            'options' => array(
                'label' => 'Subject',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'image_url',
            'type' => 'text',
            'options' => array(
                'label' => '[[image_url]]',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'category',
            'type' => 'text',
            'options' => array(
                'label' => 'Category',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'theme_color',
            'type' => 'text',
            'options' => array(
                'label' => 'Theme Color',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->get('title')->setLabel('[[title]]');
        $this->get('description')->setLabel('[[description]]');
        $this->get('image')->setLabel('[[image]]');

        $this->add(array(
            'name' => 'subtitle',
            'type' => 'text',
            'options' => array(
                'label' => '[[subtitle]]',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'calltoaction',
            'type' => 'text',
            'options' => array(
                'label' => '[[calltoaction]]',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'calltoaction_url',
            'type' => 'text',
            'options' => array(
                'label' => '[[calltoaction_url]]',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $generateSignature = new \DelamatreZendCmsAdmin\Form\Element\GenerateSignature('generate_signature');
        $generateSignature->setLabel('Generate Signature');
        $this->add($generateSignature);

        $signatureTemplate = new \DelamatreZendCmsAdmin\Form\Element\SignatureTemplate('signature_template');
        $signatureTemplate->setLabel('Signature Template');
        $this->add($signatureTemplate);

        $this->add(array(
            'name' => 'signature_name',
            'type' => 'text',
            'options' => array(
                'label' => 'Signature Name',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'signature_title',
            'type' => 'text',
            'options' => array(
                'label' => 'Signature Title',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'signature_extension',
            'type' => 'text',
            'options' => array(
                'label' => 'Signature Extension',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $this->add(array(
            'name' => 'signature_mobile',
            'type' => 'text',
            'options' => array(
                'label' => 'Signature Mobile',
            ),
            'attributes' => array(
                //'placeholder' => 'sjhdf873nd93nd9384nd93',
            ),
        ));

        $attachRelatedFiles = new YesNo('attach_related_files');
        $attachRelatedFiles->setLabel('Attach Related Files');
        $this->add($attachRelatedFiles);


    }

}