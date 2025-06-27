<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use SendGrid\Mail\Mail;

class ResetPasswordMail extends Mailable
{
    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        // Create a SendGrid email object
        $email = new Mail();
        $email->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')); // Use your env variables
        $email->setSubject("Reset Your Password");
        $email->addTo($this->details['email'], $this->details['name']);

        // Set email content
        $email->addContent("text/plain", "Please reset your password using the link below.");
        $email->addContent("text/html", "<strong>Please reset your password using the link below.</strong>");

        // Send the email using SendGrid API
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));  // Get API key from .env
        try {
            $response = $sendgrid->send($email);

            // Log the SendGrid response for debugging purposes
            \Log::info('SendGrid Response:', [
                'statusCode' => $response->statusCode(),
                'body' => $response->body(),
                'headers' => $response->headers()
            ]);

            if ($response->statusCode() == 202) {
                return "Email sent successfully!";
            } else {
                return "Failed to send email. Response Code: " . $response->statusCode();
            }
        } catch (\Exception $e) {
            \Log::error('SendGrid Error', ['message' => $e->getMessage()]);
            return "Error: " . $e->getMessage();
        }
    }
}
