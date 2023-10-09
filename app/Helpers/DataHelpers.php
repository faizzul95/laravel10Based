<?php

/**
 * Check if the provided data contains non-empty values for the specified key.
 *
 * @param mixed       $data          The data to be checked (array or string).
 * @param string|null $arrKey        The key to check within the data.
 * @param bool        $returnData    If true, returns the data value if found.
 * @param mixed       $defaultValue  The default value to return if data is not found.
 *
 * @return bool|string|null Returns true if data exists, data value if $returnData is true and data exists, otherwise null or $defaultValue.
 */
if (!function_exists('hasData')) {
    function hasData($data = NULL, $arrKey = NULL, $returnData = false, $defaultValue = NULL)
    {
        // Base case 1: Check if data is not set, empty, or null
        if (!isset($data) || empty($data) || is_null($data)) {
            return $returnData ? ($defaultValue ?? $data) : false;
        }

        // Base case 2: If arrKey is not provided, consider data itself as having data
        if (is_null($arrKey)) {
            return $returnData ? ($defaultValue ?? $data) : true;
        }

        // Replace square brackets with dots in arrKey
        $arrKey = str_replace(['[', ']'], ['.', ''], $arrKey);

        // Split the keys into an array
        $keys = explode('.', $arrKey);

        // Helper function to recursively traverse the data
        $traverse = function ($keys, $currentData) use (&$traverse, $returnData, $defaultValue) {
            if (empty($keys)) {
                return $returnData ? $currentData : true;
            }

            $key = array_shift($keys);

            // Check if $currentData is an array or an object
            if (is_array($currentData) && array_key_exists($key, $currentData)) {
                return $traverse($keys, $currentData[$key]);
            } elseif (is_object($currentData) && isset($currentData->$key)) {
                return $traverse($keys, $currentData->$key);
            } else {
                // If the key doesn't exist, return the default value or false
                return $returnData ? $defaultValue : false;
            }
        };

        return $traverse($keys, $data);
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

/**
 * Send a cURL request to the specified URL with optional form data and options.
 *
 * @param string $url               The URL to send the request to.
 * @param array  $formData          (Optional) Data to send in the request body.
 * @param string $method            (Optional) The HTTP method for the request (GET or POST).
 * @param array  $customCurlOption  (Optional) An array of cURL options to customize the request.
 *
 * @return array An associative array with 'code' (HTTP status code) and 'message' (response content).
 */
if (!function_exists('makeCurlRequest')) {
    function makeCurlRequest($url, $formData = [], $method = 'GET', $customCurlOption = [])
    {
        // Initialize cURL session
        $ch = curl_init();

        // Build the URL with query parameters if using GET
        if ($method === 'GET' && !empty($formData)) {
            $url .= '?' . http_build_query($formData);
        }

        if (!empty($optionCurl)) {
            $defaultCurlOptions = $customCurlOption;
        } else {
            $defaultCurlOptions = [
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HEADER => FALSE,
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2, // Use only TLSv1.2
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_SSL_VERIFYHOST => FALSE,
                CURLOPT_FAILONERROR => TRUE,
                CURLINFO_HEADER_OUT => TRUE,
            ];
        }

        // set curl request url
        $defaultCurlOptions[CURLOPT_URL] = $url;

        if ($method === 'POST') {
            // If using POST method, set the data and request method
            $defaultCurlOptions[CURLOPT_POST] = TRUE;
            $defaultCurlOptions[CURLOPT_POSTFIELDS] = http_build_query($formData);
        }

        curl_setopt_array($ch, $defaultCurlOptions);

        // Execute cURL session
        $response = ['code' => 200, 'message' => curl_exec($ch)];

        // Check for cURL errors
        if (curl_errno($ch)) {
            // Handle cURL error
            $error = curl_error($ch);
            $response = ['code' => 422, 'message' => 'cURL Error: ' . $error, 'error' => $error];
        }

        // Close cURL session
        curl_close($ch);

        return $response;
    }
}
