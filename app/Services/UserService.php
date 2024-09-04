<?php

namespace App\Services;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;


class UserService
{
    /** @throws \Exception */

    public function upload(User $user, array $request)
    {
        $path = $this->generateUniqueFilename();

        Storage::disk('public')
            ->put($path, Image::read($request['image'])
                ->resize(400, 600)->encode());

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
