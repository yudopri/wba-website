<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Email Verification Controller
    |----------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = 'admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware to ensure user is authenticated
        $this->middleware('auth');
        // Only apply signed middleware to the verify action
        $this->middleware('signed')->only(['verify']);
        // Throttle requests to prevent spamming
        $this->middleware('throttle:6,1')->only(['verify', 'resend']);
    }

    /**
     * The user has successfully verified their email address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function verified(Request $request)
    {
        // Custom action after email verification, if needed
        // For example, logging verification, tracking, etc.

        // Redirect to the desired page after verification
        return redirect($this->redirectTo);
    }
}
