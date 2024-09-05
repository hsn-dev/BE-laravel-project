<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvitationPolicy
{
   
    public function send(User $user): bool
    {
        return $user->isAdmin();
    }

    public function resend(User $user): bool
    {
        return $user->isAdmin();
    }
}
