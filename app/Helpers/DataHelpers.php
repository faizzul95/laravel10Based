<?php

if (!function_exists('hasData')) {
    function hasData($data = NULL, $arrKey = NULL, $returnData = false, $defaultValue = NULL)
    {
        $response = false; // default return

        // check if data is exist
        if (isset($data)) {
            if (($data !== '' || $data !== NULL || $data !== 'null') && !empty($data)) {
                // check if arrKey is exist and not null
                if (!empty($arrKey)) {
                    $keys = explode('.', $arrKey);
                    $keyArr = $keys[0];

                    if (count($keys) <= 1) {
                        if (is_array($data) && array_key_exists($keyArr, $data)) {
                            $response = !empty($data[$keyArr]) ? true : false;
                        } else if (is_object($data) && isset($data->$keyArr)) {
                            $response = !empty($data->$keyArr) ? true : false;
                        }
                    } else {
                        $remainingKeys = implode('.', array_slice($keys, 1));
                        if (is_array($data) && array_key_exists($keyArr, $data)) {
                            $response = hasData($data[$keyArr], $remainingKeys, $returnData, $defaultValue);
                        } else if (is_object($data) && isset($data->$keyArr)) {
                            $response = hasData($data->$keyArr, $remainingKeys, $returnData, $defaultValue);
                        }
                    }
                } else if (empty($arrKey)) {
                    $response = true;
                } else {
                    $response = false;
                }
            }
        }

        // if return data is set to true it will return the data instead of bool,
        if ($returnData)
            return $response && !empty($arrKey) ? $data[$arrKey] : ($response ? $data : $defaultValue);
        else
            return $response;
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
