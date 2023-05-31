<?php

namespace App\Services\Integrations\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WebNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct(Array $data)
    {
        $this->data = $data;
    }

    public function setData(Array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notific   ation.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->data['id'],
            'title' => $this->data['title'],
            'description' => $this->data['description'],
            'module' => $this->data['module'],
            'sender_id' => $this->data['sender_id'],
            'sender_name' => $this->data['sender_name'],
        ];
    }
}
