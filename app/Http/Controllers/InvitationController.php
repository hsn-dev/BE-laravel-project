<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvitationRequest;
use App\Http\Requests\UpdateInvitationRequest;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class InvitationController extends Controller
{
    public function send(StoreInvitationRequest $request)
    {
        Gate::authorize('send', Invitation::class);

        $data = $request->validated();
        $invite_token = Str::random(32);
        
        $invitation = Invitation::create([
            'email' => $data['email'],
            'invite_token' => $invite_token,
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        // Simulate sending the invite
        
        return $this->render_success($invitation, 'Invitation sent successfully');
    }

    public function resend(UpdateInvitationRequest $request)
    {
        Gate::authorize('resend', Invitation::class);
        
        $data = $request->validated();
        $invitation = Invitation::where('email', $data['email'])->where('registered', false)->first();

        if (!$invitation) {
            return $this->render_error([], 'User with this email is already registered', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $invitation->update([
            'invite_token' => Str::random(32),
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        // Simulate sending the invite

        return $this->render_success($invitation, 'Invitation resent successfully');
    }
}
