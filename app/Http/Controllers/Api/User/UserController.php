<?php

namespace App\Http\Controllers\Api\User;

use App\Console\Constants\UserResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UploadRequest;
use App\Http\Resources\GalleryResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected readonly UserService $userService)
    {
    }

    public function __invoke(UploadRequest $uploadRequest)
    {

        if (!$uploadRequest->user()) {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }

        $data = $this->userService->upload($uploadRequest->user(),$uploadRequest->validated());

        return response([
            'data' => GalleryResource::make($data),
            'message' => UserResponseEnum::USER_GALLERY,
            'success' => true
        ]);
    }
}
