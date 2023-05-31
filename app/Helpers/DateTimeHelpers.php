<?php

if (!function_exists('currentDate')) {
    function currentDate($format = 'Y-m-d')
    {
        date_default_timezone_set(env('APP_TIMEZONE'));
        return date($format);
    }
}

if (!function_exists('currentTime')) {
    function currentTime($format = 'H:i:s')
    {
        date_default_timezone_set(env('APP_TIMEZONE'));
        return date($format);
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, $format = "d.m.Y")
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('timestamp')) {
    function timestamp($format = 'Y-m-d H:i:s')
    {
        date_default_timezone_set(env('APP_TIMEZONE'));
        return date($format);
    }
}

if (!function_exists('dateDiff')) {
    function dateDiff($d1, $d2)
    {
        return round(abs(strtotime($d1) - strtotime($d2)) / 86400);
    }
}

if (!function_exists('timeDiff')) {
    function timeDiff($t1, $t2)
    {
        return round(abs(strtotime($t1) - strtotime($t2)) / 60);
    }
}

if (!function_exists('extendDate')) {
    function extendDate($dateFrom = 'Y-m-d H:i:s', $totalToAdd = '1 minutes', $extendAnotherDate = NULL, $format = 'Y-m-d H:i:s')
    {
        date_default_timezone_set(env('APP_TIMEZONE'));
        $addExtendDate = date($format, strtotime($dateFrom . ' +' . $totalToAdd));
        return hasData($extendAnotherDate) ? date($format, strtotime($addExtendDate . ' +' . $extendAnotherDate)) : $addExtendDate;
    }
}

if (!function_exists('reduceDate')) {
    function reduceDate($dateFrom = 'Y-m-d H:i:s', $totalToReduce = '1 minutes', $reduceAnotherDate = NULL, $format = 'Y-m-d H:i:s')
    {
        date_default_timezone_set(env('APP_TIMEZONE'));
        $addExtendDate = date($format, strtotime($dateFrom . ' +' . $totalToReduce));
        return hasData($reduceAnotherDate) ? date($format, strtotime($addExtendDate . ' +' . $reduceAnotherDate)) : $addExtendDate;
    }
}
