<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class QuestionnaireResponse extends Notification {
    use Queueable;

    /**
     * Title of the questionnaire/
     *
     * @var {string}
     */
    private $questionnaireTitle;

    /**
     * Number of responses.
     *
     * @var  {int}
     */
    private $responses;

    /**
     * Create a new notification instance.
     *
     * @param {string} $questionnaireTitle - Title of the questionnaire.
     * @param {int} $responses - Number of responses.
     */
    public function __construct($questionnaireTitle, $responses) {
        $this->questionnaireTitle = $questionnaireTitle;
        $this->responses = $responses;
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
            ->subject("You have a new response!")
            ->view("emails.response", [
                "name" => $notifiable->first_name,
                "title" => $this->questionnaireTitle,
                "responses" => $this->responses,
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
            "title" => "You have a new response!",
            "message" => "A new response for {$this->questionnaireTitle} has just come in. You now have {$this->responses} responses!"
        ];
    }
}
