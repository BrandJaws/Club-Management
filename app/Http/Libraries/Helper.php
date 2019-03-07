<?php
namespace App\Http\Libraries;
/**
 * Helper Class to provide centeral common functionality
 *
 * @author kas
 */

class Helper {
 
    public static function isMenuActive($path, $active = 'active')
    {
        return call_user_func_array('Request::is', (array) $path) ? $active : '';
    }
}
