<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordLink extends Notification {
    use Queueable;

    /**
     * Token to allow user to reset password.
     *
     * @var string
     */
    private $token;

    /**
     * Create a new notification instance.
     *
     * @param string $token - Token to allow user to reset password.
     */
    public function __construct($token) {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ["mail"];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject("Reset Password Link")
            ->view("emails.reset-password", [
                "token" => $this->token,
            ]);
    }
}
