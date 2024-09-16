<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Repositories\UserRepositoryInterface;

class AuthService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /** @throws \Exception */

    public function register(UserDTO $userDTO)
    {
        $user = $this->userRepository->create($userDTO);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'access_token' => $token,
        ];
    }
}
