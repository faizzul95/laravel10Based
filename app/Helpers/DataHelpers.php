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
        // Check if data is not set, empty, or null
        if (!isset($data) || empty($data) || is_null($data)) {
            return false;
        }

        // If arrKey is not provided, consider data itself as having data
        if (is_null($arrKey)) {
            return true;
        }

        // Split the keys into an array
        $keys = explode('.', $arrKey);
        $currentKey = array_shift($keys);

        // Check if data is an array and the current key exists
        if (is_array($data) && array_key_exists($currentKey, $data)) {
            // If no more keys left, return the data or true based on returnData flag
            if (empty($keys)) {
                if ($returnData) {
                    return $data[$currentKey] ?? $defaultValue;
                }
                return true;
            }

            // Recursively call hasData for the nested key
            return hasData($data[$currentKey], implode('.', $keys), $returnData, $defaultValue);
        }

        // No match found, return false or return default value
        return $returnData ? $defaultValue : false;
    }
}

/**
 * Replaces placeholders in a string with corresponding values from the provided array.
 * Placeholders are of the form %placeholder%.
 * If a placeholder is not found in the array, the original placeholder is retained.
 *
 * @param {string} $string - The input string containing placeholders.
 * @param {Array} $arrayOfStringToReplace - An associative array containing key-value pairs for replacement.
 * @returns {string} The input string with placeholders replaced by array values.
 */
if (!function_exists('replaceTextWithData')) {
    function replaceTextWithData($string = NULL, $arrayOfStringToReplace = [])
    {
        $replacedString = str_replace(
            array_map(fn ($key) => "%$key%", array_keys($arrayOfStringToReplace)),
            array_values($arrayOfStringToReplace),
            $string
        );

        return $replacedString;
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
