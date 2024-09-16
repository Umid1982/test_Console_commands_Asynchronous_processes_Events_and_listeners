<?php

namespace App\Repositories;

use App\DTOs\UserDTO;
use App\Models\User;

interface UserRepositoryInterface
{
    public function create(UserDTO $data): User;
}
