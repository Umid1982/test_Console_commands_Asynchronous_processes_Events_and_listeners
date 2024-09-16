<?php

namespace App\Services;

use App\DTOs\UploadDTO;
use App\Models\Gallery;
use App\Strategies\ImageProcessingStrategy;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class ImageService
{
    public function __construct(protected readonly ImageProcessingStrategy $strategy)
    {
    }

    /** @throws Exception */

    public function upload(Model $user, UploadDTO $payload): Gallery
    {
        $path = $this->generateUniqueFilename();

        $processedImage = $this->strategy->processImage($payload->image);

        Storage::disk('public')->put($path, $processedImage->encode());

        return $this->storeImageData($user->getKey(), $path);
    }

    /**Генерирует уникальное имя для изображения.*/
    private function generateUniqueFilename(): string
    {
        return 'images/' . uniqid() . '.jpg';
    }

    private function storeImageData(int $userId, string $filename): Gallery
    {
        /** @var Gallery $gallery */
        $gallery = Gallery::query()->create([
            'user_id' => $userId,
            'image' => $filename
        ]);

        return $gallery;
    }
}
