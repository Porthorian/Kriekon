<?php
/**
 * Auto magically get $_POST or $_GET without having to use them
 */
class Input {

  /**
   * Checks to make sure $_POST variable exists
   * @method exists
   * @param  string $type Switch between post or get
   * @return [type]       post or get
   */
    public static function exists($type = 'post') {
        switch($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;
            case 'get':
                return (!empty($_GET)) ? true : false;
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * Will grab any $_POST or $_GET named variable
     * @method get
     * @param  [type] $item name of the form field
     * @return [type]       Gives data inside variable
     */
    public static function get($item) {
        if(isset($_POST[$item])) {
            return $_POST[$item];
        } else if(isset($_GET[$item])) {
            return $_GET[$item];
        }
        return '';
    }
}
