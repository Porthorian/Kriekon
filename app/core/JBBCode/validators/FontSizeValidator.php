<?php

namespace JBBCode\validators;

require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'InputValidator.php';

/**
 * An InputValidator for urls. This can be used to make [url] bbcodes secure.
 *
 * @author jbowens
 * @since May 2013
 */
class FontSizeValidator implements \JBBCode\InputValidator
{

    /**
     * Returns true iff $input is a valid url.
     *
     * @param $input  the string to validate
     */
    public function validate($input)
    {
        if($input > 9 && $input < 72){
            $valid = true;
        } else {
            $valid = false;
        }
        return !!$valid;
    }

}
