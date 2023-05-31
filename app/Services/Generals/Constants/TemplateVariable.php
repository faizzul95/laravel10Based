<?php

namespace App\Services\Generals\Constants;

final class TemplateVariable
{
    public const USER_ID = 'user_id';
    public const USER_NAME = 'user_name';
    public const USER_EMAIL = 'user_email';
    public const USER_PASSWORD = 'user_password';
    public const STATUS_NAME = 'status_name';

    /*
     * value here is just to show in template design
     * not the actual value when
     * generate actual email/letter/invoice/receipt
     */
    public const LIST = [
        self::USER_ID => [
            'key' => 'user_id',
            'value' => '1',
        ],
        self::USER_NAME => [
            'key' => 'user_name',
            'value' => 'Winter Karina',
        ],
        self::USER_EMAIL => [
            'key' => 'user_email',
            'value' => 'winterkarina@gmail.com',
        ],
        self::USER_PASSWORD => [
            'key' => 'user_password',
            'value' => '17!!11#2020',
        ],
        self::STATUS_NAME => [
            'key' => 'status_name',
            'value' => 'Verified',
        ],
    ];
}
