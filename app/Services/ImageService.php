<?php

namespace App\Services;

use Intervention\Image\ImageManagerStatic as Image;
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
        // Create image instance
        $img = Image::make($image);

        // Resize image if it exceeds max dimensions while maintaining aspect ratio
        if ($maxWidth && $maxHeight) {
            $img->resize($maxWidth, $maxHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Generate unique filename
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();
        $fullPath = $path . '/' . $filename;

        // Convert to jpg for better compression
        $img->encode('jpg', $quality);

        // Store the compressed image
        Storage::disk('public')->put($fullPath, $img->stream());

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