<?php

namespace DelamatreZendCms\Entity;

use DelamatreZendCms\Entity\Superclass\Content as SuperclassContent;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="integer",nullable=true);
     */
    public $email_template_id;

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

    public function generateHtml(){

        /* @var EmailTemplate $emailTemplate */
        $emailTemplate = $this->emailTemplate;
        $html = $emailTemplate->generateHtml($this);

        return $html;
    }

    public function generateRelatedContentHtml($useContentHeader=true,$contentHeaderTag='h6'){

        $html = '';
        $caseStudies = $this->caseStudies;
        $documents = $this->documents;
        $videos = $this->videos;
        $whitePapers = $this->whitePapers;

        if($caseStudies){
            if($useContentHeader==true){
                $html .= "<$contentHeaderTag>Case Studies</$contentHeaderTag>\n";
            }
            foreach($caseStudies as $caseStudy){
                $html .= "<p><a href=\"#\">{$caseStudy->title} &raquo;</a></p>";
            }
        }

        if($documents){
            if($useContentHeader==true){
                $html .= "<$contentHeaderTag>Documents</$contentHeaderTag>\n";
            }
            foreach($documents as $document){
                $html .= "<p><a href=\"#\">{$document->title} &raquo;</a></p>";
            }
        }

        if($videos){
            if($useContentHeader==true){
                $html .= "<$contentHeaderTag>Videos</$contentHeaderTag>\n";
            }
            foreach($videos as $video){
                $html .= "<p><a href=\"#\">{$video->title} &raquo;</a></p>";
            }
        }

        if($whitePapers){
            if($useContentHeader==true){
                $html .= "<$contentHeaderTag>White Papers</$contentHeaderTag>\n";
            }
            foreach($whitePapers as $whitePaper){
                $html .= "<p><a href=\"#\">{$whitePaper->title} &raquo;</a></p>";
            }
        }

        return $html;
    }

}