<?php

// CURRENCY & MONEY HELPERS SECTION

/**
 * Format a number as a money value with a specified number of decimals.
 *
 * @param float $amount The amount to format.
 * @param int $decimal The number of decimal places to include in the formatted amount (default is 2).
 * @return string The formatted amount as a string.
 */
if (!function_exists('money_format')) {
    function money_format($amount, $decimal = 2)
    {
        return number_format((float)$amount, $decimal, '.', ',');
    }
}

/**
 * Format a given numeric value into a localized currency representation using the "intl" extension.
 *
 * @param float $value The numeric value to format as currency.
 * @param bool $includeSymbol (Optional) Whether to include the currency symbol in the formatted output (default is false).
 * @param string|null $code (Optional) The country code to determine the currency format (e.g., 'USD', 'EUR', 'JPY', etc.).
 * @return string The formatted currency value as a string or an error message if the "intl" extension is not installed or enabled.
 */
if (!function_exists('formatCurrency')) {
    function formatCurrency($value, $code, $includeSymbol = false)
    {
        // Check if the "intl" extension is installed and enabled
        if (!extension_loaded('intl')) {
            return 'Error: The "intl" extension is not installed or enabled, which is required for number formatting.';
        }

        if (empty($value)) {
            $value = 0.0;
        }

        // Map the country codes to their respective locale codes
        $localeMap = array(
            'USD' => ['pattern' => '$ #,##0.00', 'code' => 'en_US'], // United States Dollar (USD)
            'JPY' => ['pattern' => '¥ #,##0', 'code' => 'ja_JP'], // Japanese Yen (JPY)
            'GBP' => ['pattern' => '£ #,##0.00', 'code' => 'en_GB'], // British Pound Sterling (GBP)
            'EUR' => ['pattern' => '€ #,##0.00', 'code' => 'en_GB'], // Euro (EUR) - Using en_GB for Euro
            'AUD' => ['pattern' => 'A$ #,##0.00', 'code' => 'en_AU'], // Australian Dollar (AUD)
            'CAD' => ['pattern' => 'C$ #,##0.00', 'code' => 'en_CA'], // Canadian Dollar (CAD)
            'CHF' => ['pattern' => 'CHF #,##0.00', 'code' => 'de_CH'], // Swiss Franc (CHF)
            'CNY' => ['pattern' => '¥ #,##0.00', 'code' => 'zh_CN'], // Chinese Yuan (CNY)
            'SEK' => ['pattern' => 'kr #,##0.00', 'code' => 'sv_SE'], // Swedish Krona (SEK)
            'MYR' => ['pattern' => 'RM #,##0.00', 'code' => 'ms_MY'], // Malaysian Ringgit (MYR)
            'SGD' => ['pattern' => 'S$ #,##0.00', 'code' => 'en_SG'], // Singapore Dollar (SGD)
            'INR' => ['pattern' => '₹ #,##0.00', 'code' => 'en_IN'], // Indian Rupee (INR) - Using en_IN for Rupee
            'IDR' => ['pattern' => 'Rp #,##0', 'code' => 'id_ID'], // Indonesian Rupiah (IDR)
        );

        if (!array_key_exists($code, $localeMap)) {
            return "Error: Invalid country code.";
        }

        // Validate the $includeSymbol parameter
        if (!is_bool($includeSymbol)) {
            return "Error: \$includeSymbol parameter must be a boolean value.";
        }

        $currencyData = $localeMap[$code];

        // Create a NumberFormatter instance with the desired locale (country code)
        $formatter = new NumberFormatter($currencyData['code'], NumberFormatter::DECIMAL);

        if ($includeSymbol) {
            $formatter->setPattern($currencyData['pattern']);
        }

        // Format the currency value using the NumberFormatter
        return $formatter->formatCurrency($value, $currencyData['code']);
    }
}

// ENCODE & DECODE HELPERS SECTION

/**
 * Encode a string to Base64 format, with URL-safe characters.
 *
 * @param string $sData The data to encode to Base64.
 * @return string The Base64-encoded data with URL-safe characters.
 */
if (!function_exists('encode_base64')) {
    function encode_base64($sData = NULL)
    {
        if (hasData($sData)) {
            // Encode the data to Base64
            $sBase64 = base64_encode($sData);

            // Replace URL-unsafe characters (+ and /) with URL-safe characters (- and _)
            return strtr($sBase64, '+/', '-_');
        } else {
            // Return an empty string if input data is empty or not provided
            return '';
        }
    }
}

/**
 * Decode a Base64-encoded string with URL-safe characters.
 *
 * @param string $sData The Base64-encoded data with URL-safe characters.
 * @return string|bool The decoded data, or false if decoding fails.
 */
if (!function_exists('decode_base64')) {
    function decode_base64($sData = NULL)
    {
        if (hasData($sData)) {
            // Replace URL-safe characters (- and _) with Base64 characters (+ and /)
            $sBase64 = strtr($sData, '-_', '+/');

            // Decode the Base64-encoded data
            return base64_decode($sBase64);
        } else {
            // Return an empty string if input data is empty or not provided
            return '';
        }
    }
}

// GENERAL HELPERS SECTION

/**
 * Check if the given HTTP response code indicates success.
 *
 * @param int|string $resCode The HTTP response code to check (default: 200).
 * @return bool True if the response code is a success status, false otherwise.
 */
if (!function_exists('isSuccess')) {
    function isSuccess($resCode = 200)
    {
        $successStatus = [200, 201, 302];
        $code = (is_string($resCode)) ? (int)$resCode : $resCode;

        return in_array($code, $successStatus);
    }
}

/**
 * Check if the given HTTP response code indicates an error.
 *
 * @param int|string $resCode The HTTP response code to check (default: 400).
 * @return bool True if the response code is an error status, false otherwise.
 */
if (!function_exists('isError')) {
    function isError($resCode = 400)
    {
        $errorStatus = [400, 403, 404, 422, 500];
        $code = (is_string($resCode)) ? (int)$resCode : $resCode;

        return in_array($code, $errorStatus);
    }
}

/**
 * Generate a running number with optional prefix, suffix, and leading zeros.
 *
 * @param int|string $currentNo The current number to use as a base.
 * @param string|null $prefix The prefix to add to the generated number (default: NULL).
 * @param string|null $suffix The suffix to add to the generated number (default: NULL).
 * @param string|null $separator The separator between prefix, number, and suffix (default: NULL).
 * @param int $leadingZero The number of leading zeros for the generated number (default: 5).
 * @return array An array containing 'code' (the generated running number) and 'next' (the next number in sequence).
 */
if (!function_exists('genRunningNo')) {
    function genRunningNo($currentNo, $prefix = NULL, $suffix = NULL, $separator = NULL, $leadingZero = 5)
    {
        $nextNo = $currentNo + 1;

        // Concatenate prefix and suffix with optional separator
        $pref = empty($separator) ? $prefix : $prefix . $separator;
        $suf = !empty($suffix) ? (empty($separator) ? $suffix : $separator . $suffix) : NULL;

        // Generate the running number with leading zeros
        $generatedNumber = $pref . str_pad($nextNo, $leadingZero, '0', STR_PAD_LEFT) . $suf;

        return [
            'code' => $generatedNumber,
            'next' => $nextNo
        ];
    }
}

/**
 * Generates a unique code based on a given string and a list of existing codes.
 *
 * @param string $string The input string used to generate the code.
 * @param array $codeList An array containing existing codes to avoid duplicates.
 * @param string $codeType The code type prefix.
 * @param int $codeLength The length of the code generated from the string.
 * @param int $numLength The length of the numerical part of the code.
 * @param int $counter The starting number for generating unique codes.
 * @return string The generated unique code.
 */
if (!function_exists('genCodeByString')) {
    function genCodeByString($string, $codeList = array(), $codeType = 'S', $codeLength = 4, $numLength = 4, $counter = 1)
    {
        $code = '';

        // Convert the string to uppercase and split it into an array of words
        $nameArr = explode(' ', strtoupper($string));

        // Array to keep track of the current index of each word in the string
        $wordIdx = array();
        $word = 0;

        // Generate the code by taking characters from the input string based on the specified length
        while ($codeLength != strlen($code)) {
            // Wrap around the words if the code length is longer than the string
            if ($word >= count($nameArr)) {
                $word = 0;
            }

            // Initialize the word index if it's not set
            if (!isset($wordIdx[$word])) {
                $wordIdx[$word] = 0;
            }

            // Wrap around the characters in a word if the code length is longer than the word
            if ($wordIdx[$word] >= strlen($nameArr[$word])) {
                $wordIdx[$word] = 0;
            }

            // Append the character from the current word to the code
            $code .= $nameArr[$word][$wordIdx[$word]];

            // Move to the next character in the word
            $wordIdx[$word]++;
            $word++;
        }

        // If a list of existing codes is provided, ensure the generated code is unique
        if (hasData($codeList)) {
            $found = false;
            while (!$found) {
                $tempcode = $codeType . $code . str_pad($counter, $numLength, '0', STR_PAD_LEFT);

                // Check if the tempcode exists in the code list
                if (!in_array($tempcode, $codeList)) {
                    $code = $tempcode;
                    $found = true;
                }

                // Increment the counter to generate a new unique code if the current one already exists
                $counter++;
            }
        }

        return $code;
    }
}

/**
 * Truncates a given string to a specified length and appends a suffix if needed.
 *
 * @param string $string The input string to truncate.
 * @param int $length The maximum length of the truncated string.
 * @param string $suffix The suffix to append at the end of the truncated string.
 * @return string|null The truncated string or NULL if the input string is empty.
 */
if (!function_exists('truncateText')) {
    function truncateText($string, $length = 10, $suffix = '...')
    {
        $truncated = NULL;

        // Check if the input string has data (i.e., not empty or NULL)
        if (hasData($string)) {
            // If the string is shorter than or equal to the maximum length, return the string as is
            if (strlen($string) <= $length) {
                return $string;
            }

            // Truncate the string to the specified length
            $truncated = substr($string, 0, $length);

            // If the truncated string ends with a space, remove the space
            if (substr($truncated, -1) == ' ') {
                $truncated = substr($truncated, 0, -1);
            }

            // Append the suffix to the truncated string
            $truncated .= $suffix;
        }

        return $truncated;
    }
}
