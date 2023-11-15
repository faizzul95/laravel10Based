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
 * Retrieve a mapping of currency codes to their respective locale settings.
 * This function returns an array where each currency code is associated with an array
 * containing symbol, pattern, code, and decimal settings for formatting the currency.
 * 
 * @return array An associative array where currency codes are keys and their locale settings are values.
 */
if (!function_exists('getCurrencyMapping')) {
    function getCurrencyMapping()
    {
        // Map the country codes to their respective locale codes
        return array(
            'USD' => ['symbol' => '$', 'pattern' => '$ #,##0.00', 'code' => 'en_US', 'decimal' => 2], // United States Dollar (USD)
            'JPY' => ['symbol' => '¥', 'pattern' => '¥ #,##0', 'code' => 'ja_JP', 'decimal' => 2], // Japanese Yen (JPY)
            'GBP' => ['symbol' => '£', 'pattern' => '£ #,##0.00', 'code' => 'en_GB', 'decimal' => 2], // British Pound Sterling (GBP)
            'EUR' => ['symbol' => '€', 'pattern' => '€ #,##0.00', 'code' => 'en_GB', 'decimal' => 2], // Euro (EUR) - Using en_GB for Euro
            'AUD' => ['symbol' => 'A$', 'pattern' => 'A$ #,##0.00', 'code' => 'en_AU', 'decimal' => 2], // Australian Dollar (AUD)
            'CAD' => ['symbol' => 'C$', 'pattern' => 'C$ #,##0.00', 'code' => 'en_CA', 'decimal' => 2], // Canadian Dollar (CAD)
            'CHF' => ['symbol' => 'CHF', 'pattern' => 'CHF #,##0.00', 'code' => 'de_CH', 'decimal' => 2], // Swiss Franc (CHF)
            'CNY' => ['symbol' => '¥', 'pattern' => '¥ #,##0.00', 'code' => 'zh_CN', 'decimal' => 2], // Chinese Yuan (CNY)
            'SEK' => ['symbol' => 'kr', 'pattern' => 'kr #,##0.00', 'code' => 'sv_SE', 'decimal' => 2], // Swedish Krona (SEK)
            'MYR' => ['symbol' => 'RM', 'pattern' => 'RM #,##0.00', 'code' => 'ms_MY', 'decimal' => 2], // Malaysian Ringgit (MYR)
            'SGD' => ['symbol' => 'S$', 'pattern' => 'S$ #,##0.00', 'code' => 'en_SG', 'decimal' => 2], // Singapore Dollar (SGD)
            'INR' => ['symbol' => '₹', 'pattern' => '₹ #,##0.00', 'code' => 'en_IN', 'decimal' => 2], // Indian Rupee (INR)
            'IDR' => ['symbol' => 'Rp', 'pattern' => 'Rp #,##0', 'code' => 'id_ID', 'decimal' => 0], // Indonesian Rupiah (IDR)
        );
    }
}

/**
 * Retrieve the currency symbol for a given currency code.
 *
 * This function checks if the provided currency code exists in a currency mapping
 * and returns the corresponding currency symbol. If the currency code is not found,
 * it returns an error message indicating an invalid country code.
 *
 * @param string|null $currencyCode The currency code for which to retrieve the symbol.
 * @return string The currency symbol or an error message if the code is invalid.
 */
if (!function_exists('currencySymbol')) {
    function currencySymbol($currencyCode = NULL)
    {
        $localeMap = getCurrencyMapping();

        if (!array_key_exists($currencyCode, $localeMap)) {
            return "Error: Invalid country code.";
        }

        return $localeMap[$currencyCode]['symbol'];
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
        $localeMap = getCurrencyMapping();

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
        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $currencyData['decimal']); // Set fraction digits

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
 * Check if a URL responds with a valid HTTP status code within a specified timeout.
 *
 * This function sends a HEAD request to the given URL and checks if the response status code
 * falls within the range of 200 to 399, indicating a successful response. If the URL does not
 * respond or responds with an error status code, this function returns false.
 *
 * @param string $url The URL to check for a response.
 * @param int $timeout The maximum time, in seconds, to wait for the response (default is 10 seconds).
 *
 * @return bool Returns true if the URL responds with a valid status code, false otherwise.
 */
if (!function_exists('urlRequestChecker')) {
    function urlRequestChecker($url, $timeout = 10)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->head($url, ['http_errors' => false, 'timeout' => $timeout]);

            return $response->getStatusCode() >= 200 && $response->getStatusCode() < 400;
        } catch (\Exception $e) {
            return false;
        }
    }
}

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
        $code = (is_string($resCode)) ? (int) $resCode : $resCode;

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
        $code = (is_string($resCode)) ? (int) $resCode : $resCode;

        return in_array($code, $errorStatus);
    }
}

/**
 * Generate the next running number with optional prefix, suffix, separator, and leading zeros.
 *
 * @param int|null      $currentNo Current running number.
 * @param string|null   $prefix Prefix for the running number.
 * @param string|null   $separatorPrefix Separator for Prefix the running number.
 * @param string|null   $suffix Suffix for the running number.
 * @param string|null   $separatorSuffix Separator for Suffix the running number.
 * @param string|null   $separator Separator between prefix/suffix and the number.
 * @param int           $leadingZero Number of leading zeros for the running number.
 * 
 * @return array Associative array containing the generated code and the next number.
 */
if (!function_exists('genRunningNo')) {
    function genRunningNo($currentNo = NULL, $prefix = NULL, $separatorPrefix = NULL, $suffix = NULL, $separatorSuffix = NULL, $leadingZero = 5)
    {
        // Calculate the next running number
        $nextNo = empty($currentNo) ? 1 : (int)$currentNo + 1;

        // Construct prefix and suffix with optional separators
        $pref = empty($separatorPrefix) ? $prefix : $prefix . $separatorPrefix;
        $suf = !empty($suffix) ? (empty($separatorSuffix) ? $suffix : $separatorSuffix . $suffix) : NULL;

        // Generate the code with leading zeros and return the result as an array
        return [
            'code' => $pref . str_pad($nextNo, $leadingZero, '0', STR_PAD_LEFT) . $suf,
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

// UPLOAD HELPERS SECTION

/**
 * Compress a base64 encoded image data to the specified target size in kilobytes (KB).
 *
 * @param string    $base64Data The base64 encoded image data to compress.
 * @param int       $targetSizeKB The target size in kilobytes (KB) for the compressed image.
 * @param int       $quality The image quality for JPEG and PNG (0-100).
 *
 * @return string|null The compressed base64 encoded image data or null if compression fails.
 */
if (!function_exists('compressBase64Image')) {
    function compressBase64Image($base64Data, $targetSizeKB = 1024, $quality = 90, $originalWidth = null, $originalHeight = null)
    {
        try {
            // Decode the base64 data to binary
            $binaryData = base64_decode($base64Data);

            // Determine the image format based on the input
            $imageFormat = getBase64ImageFormat($base64Data);

            if (!in_array($imageFormat, ['jpeg', 'jpg', 'png', 'gif'])) {
                throw new Exception('Invalid image format. Only JPEG, PNG, and GIF are supported.');
            }

            // Get the image resource from the binary data
            $image = @imagecreatefromstring($binaryData);
            if (!$image) {
                throw new Exception('Failed to create image resource.');
            }

            // Get the image dimensions
            $width = imagesx($image);
            $height = imagesy($image);

            // Set the original dimensions if not provided
            if ($originalWidth === null || $originalHeight === null) {
                $originalWidth = $width;
                $originalHeight = $height;
            }

            // Calculate the current size in KB
            $currentSizeKB = strlen($binaryData) / 1024;

            if ($currentSizeKB <= $targetSizeKB) {
                // If the current size is already below the target size, return the original base64 data.
                return $base64Data;
            }

            // Calculate the new dimensions to reduce the size while maintaining aspect ratio
            $newWidth = floor($originalWidth * sqrt($targetSizeKB / $currentSizeKB));
            $newHeight = floor($originalHeight * sqrt($targetSizeKB / $currentSizeKB));

            // Create a new image resource for the resized image
            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

            // Preserve transparency for PNG images
            if (imageistruecolor($image) && imagecolortransparent($image) >= 0) {
                imagealphablending($resizedImage, false);
                imagesavealpha($resizedImage, true);
                $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
                imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
            }

            // Resize the image while maintaining aspect ratio
            imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

            // Create an output buffer
            ob_start();

            // Output the resized image to the buffer
            if ($imageFormat === 'jpeg' || $imageFormat === 'jpg') {
                imagejpeg($resizedImage, null, $quality);
            } elseif ($imageFormat === 'png') {
                imagepng($resizedImage, null, round($quality / 10) - 1);
            } elseif ($imageFormat === 'gif') {
                imagegif($resizedImage);
            }

            // Get the buffer content and convert it to base64
            $resizedBase64 = base64_encode(ob_get_clean());

            // Check the size of the resized image
            $resizedSizeKB = strlen($resizedBase64) / 1024;

            if ($resizedSizeKB <= $targetSizeKB) {
                // If the resized image meets the target size, return it
                return 'data:image/' . $imageFormat . ';base64,' . $resizedBase64;
            } else {
                // If the resized image is still larger than the target size, recursively compress it further
                return compressBase64Image($resizedBase64, $targetSizeKB, $quality, $originalWidth, $originalHeight);
            }
        } catch (Exception $e) {
            return $e->getMessage(); // Return error message
            // return $base64Data; // Return the original base64 data in case of an error
        }
    }
}

/**
 * Extracts the image format from a base64-encoded image data string.
 *
 * This function parses the provided base64-encoded image data to determine
 * the image format based on the data URI scheme. It uses a regular expression
 * to extract the image format information from the data URI.
 *
 * @param string $base64Data The base64-encoded image data string.
 *
 * @return string The lowercase image format (e.g., 'jpeg', 'png', 'gif').
 *               Defaults to 'jpeg' if the format cannot be determined.
 */
if (!function_exists('getBase64ImageFormat')) {
    function getBase64ImageFormat($base64Data)
    {
        // Regular expression to extract the image format from the data URI
        $pattern = '/^data:image\/([a-z]+);base64,/';

        // Array to store matches from the regular expression
        $matches = [];

        // Use preg_match to extract the image format
        preg_match($pattern, $base64Data, $matches);

        // Return the lowercase image format, or 'jpeg' if not found
        return isset($matches[1]) ? strtolower($matches[1]) : 'jpeg';
    }
}
