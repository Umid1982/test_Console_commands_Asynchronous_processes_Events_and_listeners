<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;

class UploadDTO
{
    public function __construct(public UploadedFile $image)
    {
    }
}
