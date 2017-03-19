<?php

namespace DelamatreZendCms\Entity;

use DelamatreZendCms\Entity\Superclass\Content as SuperclassContent;
use Doctrine\ORM\Mapping as ORM;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="email_template",indexes={
 *     @ORM\Index(name="index_key", columns={"key"}),
 *     @ORM\Index(name="index_title", columns={"title"}),
 *     @ORM\Index(name="index_created_datetime", columns={"created_datetime"}),
 *     @ORM\Index(name="index_updated_datetime", columns={"updated_datetime"}),
 *     @ORM\Index(name="index_active", columns={"active"}),
 *     @ORM\Index(name="index_find", columns={"key","active"}),
 *     @ORM\Index(name="index_sort", columns={"title","active"})
 * })
 */
class EmailTemplate extends SuperclassContent{

    /**
     * @ORM\Column(type="string",nullable=true);
     */
    public $theme_color;

    public function generateHtml(Email $email=null,$baseUrl=null){

        //get the template code
        $html = $this->content;
        $themeColorChanged = false;

        //if an email is specifieXd
        if($email){

            //fill in all of the variables
            $html = str_replace('[[title]]',$email->title,$html);
            $html = str_replace('[[description]]',$email->description,$html);
            $html = str_replace('[[image]]',$email->image,$html);
            $html = str_replace('[[image_url]]',$email->image_url,$html);
            $html = str_replace('[[subtitle]]',$email->subtitle,$html);
            $html = str_replace('[[content]]',$email->content,$html);
            $html = str_replace('[[calltoaction]]',$email->calltoaction,$html);
            $html = str_replace('[[calltoaction_url]]',$email->calltoaction_url,$html);
            if($email->theme_color && $this->theme_color){
                $themeColorChanged = true;
                $html = str_replace($this->theme_color,$email->theme_color,$html);
            }
            $html = str_replace('[[related_content]]',$email->generateRelatedContentHtml($baseUrl),$html);

            //custom function for adding attachfile macros for ablebits
            $html = str_replace('[[ablebits_attachments]]',$email->generateAblebitsAttachments('I:\Email Templates\attachments\\'),$html);

            $html = str_replace('[[signature]]',$email->generateSignature(),$html);

        }

        $inliner = new CssToInlineStyles();
        $html = $inliner->convert($html);

        //fix-me: not the best way to handle this..
        $html = str_replace("®",'&reg;',$html);

        return $html;

    }

}