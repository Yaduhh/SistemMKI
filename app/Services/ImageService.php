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

            $fileSize = $image->getSize();
            $maxSize = 2 * 1024 * 1024; // 2MB in bytes

            // Jika file lebih dari 2MB, kompres
            if ($fileSize > $maxSize) {
                \Log::info('File size exceeds 2MB, compressing', [
                    'original_size' => $fileSize,
                    'filename' => $image->getClientOriginalName()
                ]);

                $compressedImage = self::compressImage($image, $quality, $maxWidth, $maxHeight);
                Storage::disk('public')->put($fullPath, $compressedImage);
                
                // Log hasil kompresi
                $compressedSize = strlen($compressedImage);
                $compressionRatio = round((($fileSize - $compressedSize) / $fileSize) * 100, 2);
                
                \Log::info('Image compression completed', [
                    'original_size' => $fileSize,
                    'compressed_size' => $compressedSize,
                    'compression_ratio' => $compressionRatio . '%',
                    'filename' => $image->getClientOriginalName()
                ]);
            } else {
                // File kecil, simpan langsung
                Storage::disk('public')->put($fullPath, file_get_contents($image));
                \Log::info('File size under 2MB, stored without compression', [
                    'file_size' => $fileSize,
                    'filename' => $image->getClientOriginalName()
                ]);
            }

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
     * Compress image using GD library
     */
    private static function compressImage($image, $quality = 80, $maxWidth = 1920, $maxHeight = 1080)
    {
        $imagePath = $image->getPathname();
        $mimeType = $image->getMimeType();
        
        // Create image resource based on MIME type
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($imagePath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($imagePath);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($imagePath);
                break;
            default:
                throw new \Exception('Unsupported image format: ' . $mimeType);
        }

        if (!$sourceImage) {
            throw new \Exception('Failed to create image resource');
        }

        // Get original dimensions
        $originalWidth = imagesx($sourceImage);
        $originalHeight = imagesy($sourceImage);

        // Calculate new dimensions maintaining aspect ratio
        $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);
        $newWidth = (int)($originalWidth * $ratio);
        $newHeight = (int)($originalHeight * $ratio);

        // Create new image with calculated dimensions
        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG and GIF
        if ($mimeType === 'image/png' || $mimeType === 'image/gif') {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
        }

        // Resize image
        imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

        // Output to buffer
        ob_start();
        switch ($mimeType) {
            case 'image/jpeg':
                imagejpeg($newImage, null, $quality);
                break;
            case 'image/png':
                imagepng($newImage, null, 9); // PNG compression level 0-9
                break;
            case 'image/gif':
                imagegif($newImage);
                break;
        }
        $compressedData = ob_get_contents();
        ob_end_clean();

        // Clean up
        imagedestroy($sourceImage);
        imagedestroy($newImage);

        return $compressedData;
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