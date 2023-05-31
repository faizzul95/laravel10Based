<?php

namespace App\Services\Generals\Constants;

final class NotificationType {

    public const WEB = 1;
    public const EMAIL = 2;

    public const LIST = [
        self::WEB => 'WebNotification',
        self::EMAIL => 'EmailNotification'
    ];
    
}