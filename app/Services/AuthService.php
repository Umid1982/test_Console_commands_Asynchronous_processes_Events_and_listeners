<?php

namespace App\Services;

use App\Events\NewUserRegister;
use App\Http\Resources\UserResource;
use App\Models\User;

class AuthService
{
    /** @throws \Exception */

    public function register($validate)
    {
        $user = User::query()->create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => bcrypt($validate['password']),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        event(new NewUserRegister($user->email,$user->name));

        return [
            'user' => new UserResource($user),
            'access_token' => $token,
        ];
    }
}
