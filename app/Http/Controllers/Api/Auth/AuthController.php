<?php

namespace App\Http\Controllers\Api\Auth;

use App\Console\Constants\AuthResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected readonly AuthService $authService)
    {
    }

    public function __invoke(RegisterRequest $registerRequest)
    {
        $data = $this->authService->register($registerRequest->validated());

        return response([
            'user' => $data['user'],
            'access_token' => $data['access_token'],
            'token_type' => 'Bearer',
            'message' => AuthResponseEnum::USER_REGISTERED,
            'success' => true,
        ]);
    }
}
