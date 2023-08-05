<?php

/**
 * Get the current date in the specified format.
 *
 * @param string $format The format to use for the date. Default is 'Y-m-d'.
 * @return string The current date in the specified format.
 */
if (!function_exists('currentDate')) {
    function currentDate($format = 'Y-m-d')
    {
        setAppTimezone();
        return date($format);
    }
}

/**
 * Get the current time in the specified format.
 *
 * @param string $format The format to use for the time. Default is 'H:i:s'.
 * @return string The current time in the specified format.
 */
if (!function_exists('currentTime')) {
    function currentTime($format = 'H:i:s')
    {
        setAppTimezone();
        return date($format);
    }
}

/**
 * Format a given date string to the specified format.
 *
 * @param string $date The date string to format.
 * @param string $format The format to use for the date. Default is 'd.m.Y'.
 * @param mixed $defaultValue The value to return if the date is empty. Default is NULL.
 * @return string|null The formatted date string or the default value if the input date is empty.
 */
if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd.m.Y', $defaultValue = NULL)
    {
        setAppTimezone();
        return hasData($date) ? date($format, strtotime($date)) : $defaultValue;
    }
}

/**
 * Get the current timestamp in the specified format.
 *
 * @param string $format The format to use for the timestamp. Default is 'Y-m-d H:i:s'.
 * @return string The current timestamp in the specified format.
 */
if (!function_exists('timestamp')) {
    function timestamp($format = 'Y-m-d H:i:s')
    {
        setAppTimezone();
        return date($format);
    }
}

/**
 * Calculate the difference in days between two dates.
 *
 * @param string $d1 The first date.
 * @param string $d2 The second date.
 * @return int The difference in days between the two dates.
 */
if (!function_exists('dateDiff')) {
    function dateDiff($d1, $d2)
    {
        setAppTimezone();
        return round(abs(strtotime($d1) - strtotime($d2)) / 86400);
    }
}

/**
 * Calculate the difference in minutes between two times.
 *
 * @param string $t1 The first time.
 * @param string $t2 The second time.
 * @return int The difference in minutes between the two times.
 */
if (!function_exists('timeDiff')) {
    function timeDiff($t1, $t2)
    {
        setAppTimezone();
        return round(abs(strtotime($t1) - strtotime($t2)) / 60);
    }
}

/**
 * Extend a date by adding a given time interval to it.
 *
 * @param string $dateFrom The base date to extend.
 * @param string $totalToAdd The total time interval to add to the base date. Default is '1 minutes'.
 * @param string|null $extendAnotherDate An additional time interval to add to the extended date. Default is NULL.
 * @param string $format The format to use for the extended date. Default is 'Y-m-d H:i:s'.
 * @return string The extended date in the specified format.
 */
if (!function_exists('extendDate')) {
    function extendDate($dateFrom = 'Y-m-d H:i:s', $totalToAdd = '1 minutes', $extendAnotherDate = NULL, $format = 'Y-m-d H:i:s')
    {
        setAppTimezone();
        $addExtendDate = date($format, strtotime($dateFrom . ' +' . $totalToAdd));
        return hasData($extendAnotherDate) ? date($format, strtotime($addExtendDate . ' +' . $extendAnotherDate)) : $addExtendDate;
    }
}

/**
 * Reduce a date by subtracting a given time interval from it.
 *
 * @param string $dateFrom The base date to reduce.
 * @param string $totalToReduce The total time interval to subtract from the base date. Default is '1 minutes'.
 * @param string|null $reduceAnotherDate An additional time interval to subtract from the reduced date. Default is NULL.
 * @param string $format The format to use for the reduced date. Default is 'Y-m-d H:i:s'.
 * @return string The reduced date in the specified format.
 */
if (!function_exists('reduceDate')) {
    function reduceDate($dateFrom = 'Y-m-d H:i:s', $totalToReduce = '1 minutes', $reduceAnotherDate = NULL, $format = 'Y-m-d H:i:s')
    {
        setAppTimezone();
        $reduceExtendDate = date($format, strtotime($dateFrom . ' -' . $totalToReduce));
        return hasData($reduceAnotherDate) ? date($format, strtotime($reduceExtendDate . ' -' . $reduceAnotherDate)) : $reduceExtendDate;
    }
}

/**
 * Set the default timezone to the application timezone specified in the environment.
 */
if (!function_exists('setAppTimezone')) {
    function setAppTimezone()
    {
        date_default_timezone_set(env('APP_TIMEZONE'));
    }
}
