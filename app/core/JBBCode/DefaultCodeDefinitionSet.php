<?php

namespace JBBCode;

require_once 'CodeDefinition.php';
require_once 'CodeDefinitionBuilder.php';
require_once 'CodeDefinitionSet.php';
require_once 'validators/CssColorValidator.php';
require_once 'validators/UrlValidator.php';

/**
 * Provides a default set of common bbcode definitions.
 *
 * @author jbowens
 */
class DefaultCodeDefinitionSet implements CodeDefinitionSet
{

    /* The default code definitions in this set. */
    protected $definitions = array();

    /**
     * Constructs the default code definitions.
     */
    public function __construct()
    {
        /* [b] bold tag */
        $builder = new CodeDefinitionBuilder('b', '<strong>{param}</strong>');
        array_push($this->definitions, $builder->build());

        /* [i] italics tag */
        $builder = new CodeDefinitionBuilder('i', '<em>{param}</em>');
        array_push($this->definitions, $builder->build());

        /* [u] underline tag */
        $builder = new CodeDefinitionBuilder('u', '<u>{param}</u>');
        array_push($this->definitions, $builder->build());

        /* [s] underline tag */
        $builder = new CodeDefinitionBuilder('s', '<del>{param}</del>');
        array_push($this->definitions, $builder->build());

        $urlValidator = new \JBBCode\validators\UrlValidator();

        /* [url] link tag */
        $builder = new CodeDefinitionBuilder('url', '<a href="{param}">{param}</a>');
        $builder->setParseContent(false)->setBodyValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [url=http://example.com] link tag */
        $builder = new CodeDefinitionBuilder('url', '<a href="{option}">{param}</a>');
        $builder->setUseOption(true)->setParseContent(true)->setOptionValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [img] image tag */
        $builder = new CodeDefinitionBuilder('img', '<img src="{param}" />');
        $builder->setUseOption(false)->setParseContent(false)->setBodyValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [img=alt text] image tag */
        $builder = new CodeDefinitionBuilder('img', '<img src="{param}" alt="{option}" />');
        $builder->setUseOption(true)->setParseContent(false)->setBodyValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [color] color tag */
        $builder = new CodeDefinitionBuilder('color', '<span style="color: {option}">{param}</span>');
        $builder->setUseOption(true)->setOptionValidator(new \JBBCode\validators\CssColorValidator());
        array_push($this->definitions, $builder->build());

        /* [left] tag */
        $builder = new CodeDefinitionBuilder('left', '<p><div style="text-align: left;">{param}</div></p>');
        array_push($this->definitions, $builder->build());

        /* [center] tag */
        $builder = new CodeDefinitionBuilder('center', '<p><div style="text-align: center;">{param}</div></p>');
        array_push($this->definitions, $builder->build());

        /* [justify] tag */
        $builder = new CodeDefinitionBuilder('justify', '<p><div style="text-align: justify;">{param}</div></p>');
        array_push($this->definitions, $builder->build());

        /* [right] tag */
        $builder = new CodeDefinitionBuilder('right', '<p><div style="text-align: right;">{param}</div></p>');
        array_push($this->definitions, $builder->build());

        /* [br] tag */
        $builder = new CodeDefinitionBuilder('br', '<br />');
        array_push($this->definitions, $builder->build());

        /* [code] tag */
        $builder = new CodeDefinitionBuilder('code', '<pre>{param}</pre>');
        array_push($this->definitions, $builder->build());

        /* [code=name] tag */
        $builder = new CodeDefinitionBuilder('code', '<p>{option} coded:<pre>{param}</pre></p>');
        $builder->setUseOption(true);
        array_push($this->definitions, $builder->build());

        /* [quote] tag */
        $builder = new CodeDefinitionBuilder('quote', '<blockquote>{param}</blockquote>');
        array_push($this->definitions, $builder->build());

        /* [quote=name] tag */
        $builder = new CodeDefinitionBuilder('quote', '<p>{option} wrote:<blockquote>{param}</blockquote></p>');
        $builder->setUseOption(true);
        array_push($this->definitions, $builder->build());

        /* [size=#] size tag */
        $builder = new CodeDefinitionBuilder('size', '<span style="font-size: {option}px;">{param}</span>');
        $builder->setUseOption(true)->setOptionValidator(new \JBBCode\validators\FontSizeValidator());
        array_push($this->definitions, $builder->build());

        /* [font] font tag */
        $builder = new CodeDefinitionBuilder('font', '<span style="font-family: {option};">{param}</span>');
        $builder->setUseOption(true);
        array_push($this->definitions, $builder->build());

        /* [youtube] youtube tag */
        $builder = new CodeDefinitionBuilder('youtube', '<object width="425" height="350"><param name="movie" value="http://www.youtube.com/v/{param}"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/{param}" type="application/x-shockwave-flash" wmode="transparent" width="425" height="350"></embed></object>');
        array_push($this->definitions, $builder->build());

    }

    /**
     * Returns an array of the default code definitions.
     */
    public function getCodeDefinitions() 
    {
        return $this->definitions;
    }

}
