<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use App\Models\User;

class UpdateUserVerificationStatus
{
    /**
     * Handle the event.
     *
     * @param  Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        // Update the user's 'verifikasi' column to true after email verification
        $user = $event->user;
        $user->verifikasi = true;
        $user->save();
    }
}
