<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Compress and store an image
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $path
     * @param int $quality
     * @param int|null $maxWidth
     * @param int|null $maxHeight
     * @return string
     */
    public static function compressAndStore($image, $path = 'images', $quality = 80, $maxWidth = 1920, $maxHeight = 1080)
    {
        // Generate unique filename
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();
        $fullPath = $path . '/' . $filename;

        // Store the image directly without compression for now
        Storage::disk('public')->put($fullPath, file_get_contents($image));

        return $fullPath;
    }

    /**
     * Compress and store multiple images
     *
     * @param array $images
     * @param string $path
     * @param int $quality
     * @param int|null $maxWidth
     * @param int|null $maxHeight
     * @return array
     */
    public static function compressAndStoreMultiple($images, $path = 'images', $quality = 50, $maxWidth = 1920, $maxHeight = 1080)
    {
        $paths = [];
        foreach ($images as $image) {
            $paths[] = self::compressAndStore($image, $path, $quality, $maxWidth, $maxHeight);
        }
        return $paths;
    }
} 