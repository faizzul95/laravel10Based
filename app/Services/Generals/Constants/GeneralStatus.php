<?php

namespace App\Services\Generals\Constants;

final class GeneralStatus
{
    public const INACTIVE = 0;
    public const ACTIVE = 1;

    public const LIST = [
        self::INACTIVE => [
            'name' => 'Inactive',
            'css_class' => 'badge-danger',
            'badge' => 'badge-danger',
        ],
        self::ACTIVE => [
            'name' => 'Active',
            'css_class' => 'badge-primary',
            'badge' => 'badge-primary',
        ],
    ];
}
