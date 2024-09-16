<?php

namespace App\Http\Controllers\Api\User;

use App\Console\Constants\UserResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UploadRequest;
use App\Http\Resources\GalleryResource;
use App\Services\ImageService;
use App\Strategies\ResizeStrategy;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected readonly ImageService $imageService)
    {
    }

    public function __invoke(UploadRequest $uploadRequest)
    {
        $data = $this->imageService->upload($uploadRequest->user(), $uploadRequest->validated());

        return response([
            'data' => GalleryResource::make($data),
            'message' => UserResponseEnum::USER_GALLERY,
            'success' => true
        ]);
    }
}
