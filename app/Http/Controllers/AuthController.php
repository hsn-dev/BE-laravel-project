<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Invitation;
use App\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
     
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return $this->render_error([], 'The provided credentials are incorrect.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = $user->createToken($user->email)->plainTextToken;
        return $this->render_success(['user' => $user, 'token' => $token], 'Login successful');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $invitation = Invitation::query()
                        ->where('invite_token', $data['invite_token'])
                        ->where('expires_at', '>', Carbon::now())
                        ->where('registered', false)
                        ->first();

        if (!$invitation) {
            return $this->render_error([], 'Invalid or expired invite token.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user  = User::create($data);
        $role  = Role::query()->where('name', 'Client')->first();
        $user->roles()->attach($role);
        $token = $user->createToken($user->email)->plainTextToken;
        $invitation->update(['registered' => true]);

        return $this->render_success(['user' => $user, 'token' => $token], 'Registration successful');
    }
}
