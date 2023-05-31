<?php

namespace App\Services\Generals\Constants;

final class DocumentType
{
    public const EMAIL = 'EMAIL';

    public const LIST = [
        self::EMAIL => [
            'id' => 1,
            'name' => 'Email',
            'badge' => 'badge-warning',
        ],
    ];
}
