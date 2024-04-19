<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendTwoFactorCode extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = route('verify.index');

        return (new MailMessage)
            ->subject('Code à deux facteurs')
            ->greeting('Bonjour')
            ->line("Votre code à deux facteurs est {$notifiable->two_factor_code}")
            ->action('Vérifiez ici', route('verify.index'))
            ->line('Le code expirera dans 10 minutes.')
            ->line('Si vous n\'avez pas fait cette demande, veuillez l\'ignorer');

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
