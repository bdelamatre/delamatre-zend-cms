<?php

namespace DelamatreZendCms\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class CmsContent extends AbstractHelper
{

    protected $parameters;

    public function __invoke($string,$parameters)
    {
        //match everything between {{ }} tags and pass to parse function
        $string = preg_replace_callback('|{{ (.*) }}|U', function($matches) use($parameters){ return self::parse($matches,$parameters); }, $string);

        return $string;
    }

    public static function parse($matches,$parameters){

        $string =& trim($matches[1]);

        //parse variables
        /*$string = preg_replace_callback('|{(.*)}|U', function($variableMatches) use($parameters){ return self::parseVariable($variableMatches,$parameters); }, $string);

        //parse urls
        //$string = preg_replace_callback('|url((.*))}|U', function($variableMatches) use($parameters){ return self::parseVariable($variableMatches,$parameters); }, $string);*/

        //fix-me: I know, I know. I have stuff to do though.
        eval('$string = $parameters->'.$string.';');

        //parse functions

        return $string;
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

}