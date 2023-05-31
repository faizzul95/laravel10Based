<?php

if (!function_exists('hasData')) {
    function hasData($data = NULL, $arrKey = NULL)
    {
        if (isset($data)) {
            if (($data !== '' || $data !== NULL || $data !== 'null') && (!empty($data) || !is_null($data))) {
                if (!empty($arrKey) && array_key_exists($arrKey, $data))
                    return !empty($data[$arrKey]) ? true : false;
                else if (empty($arrKey))
                    return true;
                else
                    return false;
            }
        }

        return false;
    }
}

if (!function_exists('fileExist')) {
    function fileExist($path = NULL)
    {
        if (hasData($path)) {
            return file_exists($path) ? true : false;
        }

        return false;
    }
}
