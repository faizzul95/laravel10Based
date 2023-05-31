<?php

namespace App\Services\Integrations\Notifications;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Models\CORE\MasterEmailTemplate;
use App\Models\CORE\School;
use App\Services\Generals\Constants\CTIE;
use App\Services\Generals\Helpers\Strings;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Generals\Helpers\Templates;
use App\Services\Generals\Constants\GeneralStatus;
use App\Services\Generals\Constants\TemplateCategory;
use Illuminate\Notifications\Messages\MailMessage;

class EmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $data;
    private $school;
    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->school = School::find($data['school_id']);

        $masterEmailTemplate =
            MasterEmailTemplate::where('category_id', $data['category_id'])->where('school_id', $this->school->id)->where('status', GeneralStatus::ACTIVE)->exists()
            ?
            MasterEmailTemplate::where('category_id', $data['category_id'])->where('school_id', $this->school->id)->where('status', GeneralStatus::ACTIVE)->first()
            :
            MasterEmailTemplate::where('category_id', $data['category_id'])->where('school_id', CTIE::ID)->where('status', GeneralStatus::ACTIVE)->first();

        if ($masterEmailTemplate) {
            // $this->data['arrayOfStringToReplace']['schoolscan_url'] = config('app.subdomain') . '.' . config('app.domain');
            $email_subject = $masterEmailTemplate->email_name;
            Strings::replace($email_subject, Templates::defaultData($this->school, 'html'));
            Strings::replace($email_subject, $this->data['arrayOfStringToReplace']);

            $email_content = $masterEmailTemplate->email_content;
            Strings::replace($email_content, Templates::defaultData($this->school, 'html'));
            Strings::replace($email_content, $this->data['arrayOfStringToReplace']);

            if($masterEmailTemplate->template_design_id){
                $templateData = Templates::defaultReplace($masterEmailTemplate->template_design_id, $this->school, 'html');

                Templates::contentReplace($templateData['body'], $email_content);
                $this->data['templateData'] = $templateData;
            }

            $this->data['subject'] = $this->data['email_subject'] ? $this->data['email_subject'] : $email_subject;
            $this->data['content'] = $email_content;
        }
    }

    public function setData(array $data)
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (isset($this->data['content'])) {
            if (isset($this->data['templateData'])) {
                return (new MailMessage)->view('templateDesign.template', $this->data['templateData'])->subject($this->data['subject']);
            }else{
                return (new MailMessage)->view('email.masterContent', ['content' => $this->data['content']])->subject($this->data['subject']);
            }
        } else {
            return (new MailMessage)
                ->greeting('Hello!')
                ->line('This is email for '.TemplateCategory::LIST[$this->data['category_id']]['name']);
        }
    }

    public function failed(Exception $exception)
    {
        Log::channel('mail')->emergency('Critical job Failed! - ' . $exception->getMessage());
    }
}
