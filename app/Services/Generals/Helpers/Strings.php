<?php

namespace App\Services\Generals\Helpers;

class Strings
{
    /**
     * @param String &$string
     * @param Array $arrayOfStringToReplace
     */
    public static function replace(String &$string, Array $arrayOfStringToReplace, String $prefix = '%', String $suffix = '%'){
        foreach($arrayOfStringToReplace as $index => $value){
            $string = str_replace($prefix.$index.$suffix, $value, $string);
        }
    }
}
