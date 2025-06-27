<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SendGrid;
use SendGrid\Mail\Mail;
use Illuminate\Support\Str;

class SendGridEmailController extends Controller
{
    // In SendGridEmailController.php

    public function showSendEmailForm()
    {
        return view('auth.passwords.sendgrid-email');
    }

    // Function to send email with plain content (no template)
    public function sendEmailWithContent(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $email = $request->email;
        $name = $request->name;

        // Generate reset token using Str::random
        $resetToken = Str::random(64);
        $resetLink = route('reset.password.form', ['token' => $resetToken]);

        // Log the values for debugging
        \Log::info('Name: ' . $name);
        \Log::info('Reset Token: ' . $resetToken);
        \Log::info('Reset Link: ' . $resetLink);

        // Send email using SendGrid API
        return $this->sendEmail($email, $name, $resetLink);
    }

    // Function to send test email
    public function sendTestEmail()
    {
        $email = 'testrecipient@example.com'; // Use a test email address
        $name = 'Test User'; // Name of the recipient

        $resetToken = Str::random(64); // You might not need this for the test email
        $resetLink = route('reset.password.form', ['token' => $resetToken]);

        return $this->sendEmail($email, $name, $resetLink);
    }

    // Common method to send an email without template (plain content)
    private function sendEmail($email, $name, $resetLink)
    {
        $sendgrid = new SendGrid(env('SENDGRID_API_KEY'));

        $mail = new Mail();
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $mail->setSubject("Welcome to Our Service");
        $mail->addTo($email, $name);

        // Add plain text content
        $plainTextContent = "Hello, $name. Here is your reset link: $resetLink";

        // Add the plain text content to the email
        $mail->addContent("text/plain", $plainTextContent);

        try {
            // Send the email
            $response = $sendgrid->send($mail);
            if ($response->statusCode() == 202) {
                return back()->with('success', 'Email sent successfully!');
            } else {
                return back()->with('error', 'Failed to send email. Status Code: ' . $response->statusCode());
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
