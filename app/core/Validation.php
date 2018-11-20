<?php
/**
 * Verfiy inputs meet defined rules
 */
class Validate {
    private $_passed = false;
    private $_errors = array();
    private $_db = null;
    public function __construct() {
        $this->_db = DB::getInstance();
    }

    /**
     * Method that will parse the config at the top of the controller
     * @method check
     * @param  string $source parent array of rules
     * @param  array  $items  each rule
     * @return string         Returns a boolean or value
     */
    public function check($source, $items = array()) {
        foreach($items as $item => $rules) {
            foreach($rules as $rule => $rule_value) {
                $value = $source[$item];
                $item = escape($item);
                if($rule === 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } else if (!empty($value)) {
                    switch($rule) {
                        case 'min':
                            if(strlen($value) < $rule_value) {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters.");
                            }
                            break;
                        case 'max':
                            if(strlen($value) > $rule_value) {
                                $this->addError("{$item} must be a maximum of {$rule_value} characters.");
                            }
                            break;
                        case 'matches':
                            if($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} must match {$item}.");
                            }
                            break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check->count()) {
                                $this->addError("{$item} already exists.");
                            }
                            break;
                    }
                }
            }
        }
        if(empty($this->_errors)) {
            $this->_passed = true;
        }
    }

    /**
     * Adds error to check
     * @method addError
     * @param  string   $error Outputs error string
     */
    private function addError($error) {
        $this->_errors[] = $error;
    }

    /**
     * Catches errors
     * @method errors
     * @return string
     */
    public function errors() {
        return $this->_errors;
    }

    /**
     * If passed, give boolean
     * @method passed
     * @return boolean
     */
    public function passed() {
        return $this->_passed;
    }
}
