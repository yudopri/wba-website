<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    public $token;

    // Constructor should receive the token
    public function __construct($token)
    {
        $this->token = $token;
    }

    // Specify the delivery channels
    public function via($notifiable)
    {
        return ['database']; // Use database as the delivery channel
    }

    // The notification will be stored in the database
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'You requested a password reset.',
            'reset_token' => $this->token,  // Pass the token to the database
        ];
    }

    // Optionally, you can define other channels like mail, SMS, etc.
    // Example: public function toMail($notifiable) {...}
}

