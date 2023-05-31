<?php

namespace App\Services\Generals\Constants;

final class MasterProfileGroup
{
    public const SUPERADMIN = 1;
    public const ADMIN = 2;
    public const SUPPORT = 3;

    public const LIST = [
        self::SUPERADMIN => [
            'name' => 'Superadmin',
            'role_name' => 'superadmin',
        ],
        self::ADMIN => [
            'name' => 'Admin',
            'role_name' => 'admin',
        ],
        self::SALES => [
            'name' => 'Sales',
            'role_name' => 'sales',
        ]
    ];
}
