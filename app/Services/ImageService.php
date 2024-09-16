<?php

namespace App\Services;

use App\Models\Gallery;
use App\Models\User;
use App\Strategies\ImageProcessingStrategy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;


class ImageService
{
    public function __construct(protected readonly ImageProcessingStrategy $strategy)
    {
    }

    /** @throws \Exception */

    public function upload(Model $user, array $request)
    {
        $path = $this->generateUniqueFilename();

        $processedImage = $this->strategy->processImage($request['image']);

        Storage::disk('public')->put($path,$processedImage->encode());

        return $this->storeImageData($user->id, $path);
    }

    /**Генерирует уникальное имя для изображения.*/
    private function generateUniqueFilename()
    {
        return 'images/' . uniqid() . '.jpg';
    }

    private function storeImageData(int $userId, string $filename)
    {
        return Gallery::query()->create([
            'user_id' => $userId,
            'image' => $filename
        ]);
    }
}
