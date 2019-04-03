<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ExpiringQuestionnaire extends Notification {
    use Queueable;

    /**
     * If true, the questionnaire has expired, otherwise it is notifying the user that it will expiring in a certain amount of time.
     *
     * @var {boolean}
     */
    private $hasExpired;

    /**
     * Title of the questionnaire.
     *
     * @var {string}
     */
    private $questionnaireTitle;

    /**
     * How long till it expires.
     *
     * @var {string}
     */
    private $expiringIn;

    /**
     * Create a new notification instance.
     *
     * @param boolean $hasExpired - If true, the questionnaire has expired, otherwise it is notifying the user that it will expiring in a certain amount of time.
     * @param string $questionnaireTitle - Title of the questionnaire.
     * @param string $expiringIn - How long till it expires.
     */
    public function __construct($hasExpired, $questionnaireTitle, $expiringIn="") {
        $this->hasExpired = $hasExpired;
        $this->questionnaireTitle = $questionnaireTitle;
        $this->expiringIn = $expiringIn;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        $channels = [];

        // Only show in data (via database) if settings is enabled
        if ($notifiable->settings->enable_in_app_notifications)
            $channels[] = "database";

        // Only email notification if setting is enabled
        if ($notifiable->settings->enable_email_notifications)
            $channels[] = "mail";

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject($this->hasExpired ? "One of your questionnaires has expired!" : "One of your questionnaires is expiring soon!")
            ->view("emails.expiring", [
                "hasExpired" => $this->hasExpired,
                "name" => $notifiable->first_name,
                "title" => $this->questionnaireTitle,
                "expiring" => $this->expiringIn,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            "title" => $this->hasExpired ? "One of your questionnaires has expired!" : "One of your questionnaires is expiring soon!",
            "message" => $this->hasExpired ?
                "{$this->questionnaireTitle} has expired!\nYou can remove or extend the expiry date by editing the questionnaire." :
                "{$this->questionnaireTitle} will be expiring in one {$this->expiringIn}!\nYou can remove or extend the expiry date by editing the questionnaire."
        ];
    }
}
