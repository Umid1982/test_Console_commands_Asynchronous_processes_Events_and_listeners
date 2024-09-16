<?php

namespace App\Strategies;

use Intervention\Image\Image;

interface ImageProcessingStrategy
{
    public function processImage($image): Image;
}
