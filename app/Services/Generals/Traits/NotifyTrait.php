<?php

namespace App\Services\Generals\Traits;

use Auth;
use App\Services\Generals\Constants\NotificationType;

trait NotifyTrait
{
    protected function notifyWeb($receivers, $id, $module, $title, $description, int $school_id = null)
    {
        app('App\Services\Modules\GENERAL\Notifications\Processors\NotificationStoreProcessor')->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'module' => $module,
            'sender_id' => Auth::user() ? Auth::user()->id : null,
            'sender_name' => Auth::user() ? Auth::user()->name : null,
        ], NotificationType::LIST[NotificationType::WEB], $receivers);
    }

    protected function notifyEmail($receivers, $emailCategory, $arrayOfStringToReplace, int $school_id = null, $email_subject = null)
    {
        // app('App\Services\Modules\GENERAL\Notifications\Processors\NotificationStoreProcessor')->execute(['id' => 1, 'category_id' => $emailCategory, 'arrayOfStringToReplace' => $arrayOfStringToReplace, 'school_id' => $school_id ? $school_id : Auth::user()->currentSchoolId(), 'email_subject'=> $email_subject], NotificationType::LIST[NotificationType::EMAIL], $receivers);
    }
}
