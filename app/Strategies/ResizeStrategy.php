<?php

namespace App\Strategies;

use Intervention\Image\Image;
use Intervention\Image\Laravel\Facades\Image as ImageFacade;

class ResizeStrategy implements ImageProcessingStrategy
{
    public function processImage($image): Image
    {
        return ImageFacade::read($image)->resize(400, 600);
    }
}


