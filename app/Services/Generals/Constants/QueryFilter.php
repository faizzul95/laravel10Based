<?php

namespace App\Services\Generals\Constants;

final class QueryFilter {

    public const DEFAULT_PAGINATION = 10;
    
    public const IN_CONDITIONS = ['IN', 'NOT IN', 'BETWEEN'];
    public const CONDITION_FUNCTIONS = [
        '=' => 'where',
        '!=' => 'where',
        'LIKE' => 'where',
        'IN' => 'whereIn',
        'NOT IN' => 'whereNotIn',
        'BETWEEN' => 'whereBetween',
    ];
}