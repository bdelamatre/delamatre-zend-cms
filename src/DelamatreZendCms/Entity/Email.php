<?php

namespace DelamatreZendCms\Entity;

use Application\Controller\ResourceController;
use DelamatreZend\Entity\User;
use DelamatreZendCms\Entity\Superclass\Content as SuperclassContent;
use DelamatreZendCmsAdmin\Form\Element\GenerateSignature;
use DelamatreZendCmsAdmin\Form\Element\SignatureTemplate;
use Doctrine\ORM\Mapping as ORM;
use Zend\Mime\Message;
use Zend\Mime\Mime;
use Zend\Mime\Part;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="email",indexes={
 *     @ORM\Index(name="index_key", columns={"key"}),
 *     @ORM\Index(name="index_title", columns={"title"}),
 *     @ORM\Index(name="index_created_datetime", columns={"created_datetime"}),
 *     @ORM\Index(name="index_updated_datetime", columns={"updated_datetime"}),
 *     @ORM\Index(name="index_active", columns={"active"}),
 *     @ORM\Index(name="index_find", columns={"key","active"}),
 *     @ORM\Index(name="index_sort", columns={"title","active"})
 * })
 */
class Email extends SuperclassContent{

    /**
     * @ORM\Column(type="string")
     */
    public $subject;

    /**
     * @ORM\Column(type="integer",nullable=true);
     */
    public $email_template_id;

    /**
     * @ORM\Column(type="string")
     */
    public $image_url;

    /**
     * @ORM\Column(type="string",nullable=true);
     */
    public $theme_color;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $category;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $subtitle;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $calltoaction;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $calltoaction_url;

    /**
     * @ORM\Column(type="integer")
     */
    public $generate_signature = 0;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $signature_template;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $signature_name;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $signature_title;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $signature_extension;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    public $signature_mobile;

    /**
     * @ORM\Column(type="boolean")
     */
    public $attach_related_files = 1;


    /**
     * @ORM\ManyToMany(targetEntity="Video", inversedBy="emails")
     * @ORM\JoinTable(name="email_video")
     */
    public $videos;

    /**
     * @ORM\ManyToMany(targetEntity="Document", inversedBy="emails")
     * @ORM\JoinTable(name="email_document")
     */
    public $documents;

    /**
     * @ORM\ManyToMany(targetEntity="CaseStudy", inversedBy="emails")
     * @ORM\JoinTable(name="email_case_study")
     */
    public $caseStudies;

    /**
     * @ORM\ManyToMany(targetEntity="WhitePaper", inversedBy="emails")
     * @ORM\JoinTable(name="email_white_paper")
     */
    public $whitePapers;

    /**
     * @ORM\ManyToMany(targetEntity="Content", inversedBy="emails")
     * @ORM\JoinTable(name="email_pages")
     */
    public $pages;

    /**
     * @ORM\ManyToOne(targetEntity="EmailTemplate", inversedBy="emails")
     * @ORM\JoinColumn(name="email_template_id", referencedColumnName="id")
     */
    public $emailTemplate;

    public function __construct() {
        $this->videos               = new \Doctrine\Common\Collections\ArrayCollection();
        $this->documents            = new \Doctrine\Common\Collections\ArrayCollection();
        $this->caseStudies          = new \Doctrine\Common\Collections\ArrayCollection();
        $this->whitePapers          = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function generateMessage($baseUrl=null){


        $html = $this->generateHtml($baseUrl);

        // first create the parts
        $body = new Part($html);
        $body->type = Mime::TYPE_HTML;
        $body->charset = 'utf-8';

        $attachments = array();

        if($this->attach_related_files==true){

            //documents
            /** @var Document $document */
            foreach($this->documents as $document){

                $filename = 'public/'.$document->getDownload();

                $attachment = new Part(file_get_contents($filename));
                $attachment->type = mime_content_type($filename);
                $attachment->filename = basename($filename);
                $attachment->disposition = Mime::DISPOSITION_ATTACHMENT;
                // Setting the encoding is recommended for binary data
                $attachment->encoding = Mime::ENCODING_BASE64;
                $attachments[] = $attachment;

            }

            //whitepapers
            /** @var WhitePaper $whitePaper */
            foreach($this->whitePapers as $whitePaper){

                $filename = 'public/'.$whitePaper->getDownload();

                $attachment = new Part(file_get_contents($filename));
                $attachment->type = mime_content_type($filename);
                $attachment->filename = basename($filename);
                $attachment->disposition = Mime::DISPOSITION_ATTACHMENT;
                // Setting the encoding is recommended for binary data
                $attachment->encoding = Mime::ENCODING_BASE64;
                $attachments[] = $attachment;

            }

        }

        // then add them to a MIME message
        $mimeMessage = new Message();
        $mimeMessage->setParts(array_merge(array($body),$attachments));
        return $mimeMessage;

    }

    public function getSubject(){
        return $this->subject;
    }

    public function generateHtml($baseUrl=null){

        /* @var EmailTemplate $emailTemplate */
        $emailTemplate = $this->emailTemplate;
        $html = $emailTemplate->generateHtml($this,$baseUrl);

        return $html;
    }

    public function setUser(User $user){
        $this->user = $user;
    }

    public function getUser(){
        return $this->user;
    }

    public function generateSignature(){

        if($this->generate_signature===GenerateSignature::YES_STATIC){
            switch($this->signature_template){
                case SignatureTemplate::TEMPLATE_VULCAN:
                    return ResourceController::generateSignatureHtml($this->signature_name,$this->signature_title,$this->signature_extension,$this->signature_mobile);
                case SignatureTemplate::TEMPLATE_VULCAN_SIMPLE:
                    return ResourceController::generateSimpleSignatureHtml($this->signature_name,$this->signature_title,$this->signature_extension,$this->signature_mobile);
                default:
                    return ResourceController::generateSimpleSignatureHtml($this->signature_name,$this->signature_title,$this->signature_extension,$this->signature_mobile);
            }
        }elseif($this->generate_signature===GenerateSignature::YES_AUTO){
            if(isset($this->user) && $this->user instanceof User){
                return ResourceController::generateSimpleSignatureHtml($this->user->displayName,$this->user->title,$this->user->office,$this->user->mobile);
            }else{
                return '';
            }
        }else{
            return '';
        }

    }

    public function getAttachments($prepend='public'){

        $attachments = array();

        //documents
        /** @var Document $document */
        foreach($this->documents as $document){

            $filename = $prepend.$document->getDownload();

            $attachments[] = $filename;

        }

        //whitepapers
        /** @var WhitePaper $whitePaper */
        foreach($this->whitePapers as $whitePaper){

            $filename = $prepend.$whitePaper->getDownload();

            $attachments[] = $filename;

        }

        return $attachments;

    }

    public function generateAblebitsAttachments($attachmentFilePath='I:\Email Templates\attachments\\'){

        $html= '';
        $attachments = $this->getAttachments();

        foreach($attachments as $attachment){

            $filename = basename($attachment);

            $html .= "~%ATTACHFILE={$attachmentFilePath}{$filename} <br/>";
        }

        return $html;
    }

    public function generateRelatedContentHtml($baseUrl=null,$useContentHeader=true,$contentHeaderTag='h4'){

        $html = '';
        $caseStudies = $this->caseStudies;
        $documents = $this->documents;
        $videos = $this->videos;
        $whitePapers = $this->whitePapers;

        if(count($caseStudies)>0){
            if($useContentHeader==true){
                $html .= "<$contentHeaderTag>Case Studies</$contentHeaderTag>\n";
            }
            foreach($caseStudies as $caseStudy){
                $html .= "<p><a href=\"$baseUrl{$caseStudy->getUrl()}\">{$caseStudy->title} >></a></p>";
            }
        }

        if(count($documents)>0){
            if($useContentHeader==true){
                $html .= "<$contentHeaderTag>Documents</$contentHeaderTag>\n";
            }
            foreach($documents as $document){
                $html .= "<p><a href=\"$baseUrl{$document->getDownload()}\">{$document->title} >></a></p>";
            }
        }

        if(count($videos)>0){
            if($useContentHeader==true){
                $html .= "<$contentHeaderTag>Videos</$contentHeaderTag>\n";
            }
            foreach($videos as $video){
                $html .= "<p><a href=\"{$video->getUrl()}\">{$video->title} >></a></p>";
            }
        }

        if(count($whitePapers)>0){
            if($useContentHeader==true){
                $html .= "<$contentHeaderTag>White Papers</$contentHeaderTag>\n";
            }
            foreach($whitePapers as $whitePaper){
                $html .= "<p><a href=\"$baseUrl{$whitePaper->getDownload()}\">{$whitePaper->title} >></a></p>";
            }
        }

        return $html;
    }

}