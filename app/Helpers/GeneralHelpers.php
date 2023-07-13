<?php

// CURRENCY & MONEY HELPERS SECTION

if (!function_exists('currency_format')) {
    function currency_format($amount, $decimal = 2)
    {
        return number_format((float)$amount, $decimal, '.', ',');
    }
}

// ENCODE & DECODE HELPERS SECTION

if (!function_exists('encode_base64')) {
    function encode_base64($sData = NULL)
    {
        if (!empty($sData)) {
            $sBase64 = base64_encode($sData);
            return strtr($sBase64, '+/', '-_');
        } else {
            return '';
        }
    }
}

if (!function_exists('decode_base64')) {
    function decode_base64($sData = NULL)
    {
        if (!empty($sData)) {
            $sBase64 = strtr($sData, '-_', '+/');
            return base64_decode($sBase64);
        } else {
            return '';
        }
    }
}

// GENERAL HELPERS SECTION

if (!function_exists('isSuccess')) {
    function isSuccess($resCode = 200)
    {
        $successStatus = [200, 201, 302];
        $code = (is_string($resCode)) ? (int)$resCode : $resCode;

        if (in_array($code, $successStatus)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('isError')) {
    function isError($resCode = 400)
    {
        $errorStatus = [400, 403, 404, 422, 500];
        $code = (is_string($resCode)) ? (int)$resCode : $resCode;

        if (in_array($code, $errorStatus)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('genRunningNo')) {
    function genRunningNo($currentNo, $prefix = NULL, $suffix = NULL, $separator = NULL, $leadingZero = 5)
    {
        $nextNo = $currentNo + 1;

        $pref = empty($separator) ? $prefix : $prefix . $separator;
        $suf = !empty($suffix) ? (empty($separator) ? $suffix : $separator . $suffix) : NULL;

        return [
            'code' => $pref . str_pad($nextNo, $leadingZero, 0, STR_PAD_LEFT) . $suf,
            'next' => $nextNo
        ];
    }
}

if (!function_exists('genCodeByString')) {
    function genCodeByString($string, $codeList = array(), $codeType = 'S', $codeLength = 4, $numLength = 4, $counter = 1)
    {
        $code = '';

        $nameArr = explode(' ', strtoupper($string));
        $wordIdx = array();
        $word = 0;

        while ($codeLength != strlen($code)) {
            if ($word >= count($nameArr)) {
                $word = 0;
            }
            if (!isset($wordIdx[$word])) {
                $wordIdx[$word] = 0;
            }
            if ($wordIdx[$word] >= strlen($nameArr[$word])) {
                $wordIdx[$word] = 0;
            }

            $code .= $nameArr[$word][$wordIdx[$word]];
            $wordIdx[$word]++;
            $word++;
        }

        if (hasData($codeList)) {
            $found = false;
            while (!$found) {
                $tempcode = $codeType . $code . str_pad($counter, $numLength, '0', STR_PAD_LEFT);

                if (!in_array($tempcode, $codeList)) {
                    $code = $tempcode;
                    $found = true;
                }

                $counter++;
            }
        }

        return $code;
    }
}

if (!function_exists('truncateText')) {
    function truncateText($string, $length = 10, $suffix = '...')
    {
        $truncated = NULL;

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
