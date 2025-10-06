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
        try {
            // Generate unique filename
            $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            $fullPath = $path . '/' . $filename;

            // Ensure directory exists
            $directory = storage_path('app/public/' . $path);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Store the image directly without compression for now
            Storage::disk('public')->put($fullPath, file_get_contents($image));

            return $fullPath;
        } catch (\Exception $e) {
            \Log::error('ImageService compressAndStore error', [
                'error' => $e->getMessage(),
                'path' => $path,
                'filename' => $image->getClientOriginalName()
            ]);
            throw new \Exception('Gagal menyimpan gambar: ' . $e->getMessage());
        }
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
        $errors = [];
        
        foreach ($images as $index => $image) {
            try {
                $paths[] = self::compressAndStore($image, $path, $quality, $maxWidth, $maxHeight);
            } catch (\Exception $e) {
                $errors[] = "File " . ($index + 1) . ": " . $e->getMessage();
            }
        }
        
        if (!empty($errors)) {
            throw new \Exception('Beberapa file gagal diupload: ' . implode(', ', $errors));
        }
        
        return $paths;
    }
} 