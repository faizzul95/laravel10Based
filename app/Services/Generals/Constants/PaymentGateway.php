<?php

namespace App\Services\Generals\Constants;

final class PaymentGateway
{
    public const RAZER = 1;
    public const IPAY = 2;
    public const FPX = 3;
    public const UPAY = 4;
    public const BILLPLZ = 5;

    public const LIST = [
        self::RAZER => [
            'name' => 'Razer',
            'badge' => 'badge-warning',
            'url_uat' => 'https://sandbox.merchant.razer.com',
            'url_live' => 'https://pay.merchant.razer.com',
        ],
        self::IPAY => [
            'name' => 'Ipay 88',
            'badge' => 'badge-success',
            'url_uat' => '',
            'url_live' => '',
        ],
        self::FPX => [
            'name' => 'FPX',
            'badge' => 'badge-success',
            'url_uat' => '',
            'url_live' => '',
        ],
        self::UPAY => [
            'name' => 'Upay',
            'badge' => 'badge-success',
            'url_uat' => '',
            'url_live' => '',
        ],
        self::BILLPLZ => [
            'name' => 'BillPlz',
            'badge' => 'badge-success',
            'url_uat' => '',
            'url_live' => '',
        ],
    ];
}
