<?php

namespace DelamatreZendCms\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class CmsContent extends AbstractHelper
{

    protected $parameters;

    public function __invoke($string,$parameters,$absoluteUrls=true,$baseUrl=null)
    {

        //match everything between {{ }} tags and pass to parse function
        $string = preg_replace_callback('|{{ (.*) }}|U', function($matches) use($parameters){ return self::parse($matches,$parameters); }, $string);

        if($absoluteUrls==true){
            $string = preg_replace_callback('|href="(.*)"|U', function($matches) use($parameters,$baseUrl){ return self::absoluteUrls($matches,$parameters,$baseUrl); }, $string);
        }

        return $string;
    }

    public static function parse($matches,$parameters){

        $string =& $matches[1];

        $string = trim($string);

        //parse variables
        /*$string = preg_replace_callback('|{(.*)}|U', function($variableMatches) use($parameters){ return self::parseVariable($variableMatches,$parameters); }, $string);

        //parse urls
        //$string = preg_replace_callback('|url((.*))}|U', function($variableMatches) use($parameters){ return self::parseVariable($variableMatches,$parameters); }, $string);*/

        /*if((strstr($string,'(')==true || strstr($string,'>')==true || strstr($string,'&gt;')==true || strstr($string,'partial')==true)
            || (method_exists($parameters,$string) || property_exists($parameters,$string))){
            //fix-me: I know, I know. I have stuff to do though.*/
            eval('$string = $parameters->'.$string.';');
            return $string;
        /*}else{
            return 'function not available: '.$string;
        }*/
    }

    public static function parseVariable($matches,$parameters){

        $string =& $matches[1];

        //gets all of the variables that were passed to the view
        /* @var $parameters \Zend\View\Renderer\PhpRenderer */
        $variables = get_object_vars($parameters->vars());

        //fix-me: this isn't complex enough
        $string = $variables[$string];

        return $string;

    }

    public static function absoluteUrls($matches,$parameters,$baseUrl){

        $string =& $matches[1];

        $string = trim($string);

        //probably a better way to handle this
        if(!strstr($string,'http://')
            && !strstr($string,'https://')){
            $string = $baseUrl.$string;
        }

        $string = 'href="'.$string.'"';

        return $string;
    }

}