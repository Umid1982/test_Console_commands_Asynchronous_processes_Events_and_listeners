<?php

namespace App\Http\Controllers\Api\Auth;

use App\Console\Constants\AuthResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(protected readonly AuthService $authService)
    {
    }

    public function __invoke(RegisterRequest $request)
    {
        $data = $this->authService->register($request->toDto());

        return response([
            'user' => new UserResource($data['user']),
            'access_token' => $data['access_token'],
            'token_type' => 'Bearer',
            'message' => AuthResponseEnum::USER_REGISTERED,
            'success' => true,
        ]);
    }
}
