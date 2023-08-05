<?php

/**
 * Check if a given data has a specific value at a nested key path.
 *
 * @param mixed $data The data to check.
 * @param string|null $arrKey The nested key path (dot-separated) to check in the data.
 * @param bool $returnData If set to true, the function returns the data instead of a boolean.
 * @param mixed|null $defaultValue The default value to return if the key path does not exist.
 * @return bool|mixed If $returnData is true, returns the data at the nested key path if it exists, otherwise a boolean indicating if the key path exists.
 */
if (!function_exists('hasData')) {
    function hasData($data = NULL, $arrKey = NULL, $returnData = false, $defaultValue = NULL)
    {
        $response = false; // Default return

        // Check if data is not null
        if (isset($data)) {
            // Check if data is not empty, null, or string 'null'
            if (($data !== '' && $data !== 'null') && !empty($data)) {
                // Check if arrKey is specified and not empty
                if (!empty($arrKey)) {
                    $keys = explode('.', $arrKey);
                    $keyArr = $keys[0];

                    // If there are no more nested keys
                    if (count($keys) <= 1) {
                        if (is_array($data) && array_key_exists($keyArr, $data)) {
                            $response = !empty($data[$keyArr]) ? true : false;
                        } else if (is_object($data) && isset($data->$keyArr)) {
                            $response = !empty($data->$keyArr) ? true : false;
                        }
                    } else {
                        // If there are more nested keys, call the function recursively
                        $remainingKeys = implode('.', array_slice($keys, 1));
                        if (is_array($data) && array_key_exists($keyArr, $data)) {
                            $response = hasData($data[$keyArr], $remainingKeys, $returnData, $defaultValue);
                        } else if (is_object($data) && isset($data->$keyArr)) {
                            $response = hasData($data->$keyArr, $remainingKeys, $returnData, $defaultValue);
                        }
                    }
                } else if (empty($arrKey)) {
                    // If arrKey is empty, it means the data itself is considered present
                    $response = true;
                } else {
                    // If arrKey is not set or invalid, consider the data as not present
                    $response = false;
                }
            }
        }

        // If return data is set to true, return the data at the nested key path (if exists) or the default value.
        if ($returnData)
            return $response && !empty($arrKey) ? stringToNestedArray($arrKey, $data, $defaultValue) : ($response ? $data : $defaultValue);
        else
            return $response;
    }
}

/**
 * Check if a file exists at the given path.
 *
 * @param string|null $path The file path to check.
 * @return bool Returns true if the file exists, otherwise false.
 */
if (!function_exists('fileExist')) {
    function fileExist($path = NULL)
    {
        // Check if the path is not null and call the hasData function to validate the path.
        if (hasData($path)) {
            return file_exists($path) ? true : false;
        }

        return false;
    }
}
