<?php

namespace App\Services\BukuTamu;

use App\Exceptions\ImageProcessingException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    /**
     * Process and store base64 image data with security checks.
     *
     * @param  string  $base64Data  Base64 encoded image data
     * @param  string|null  $folder  Optional folder path
     * @param  bool  $compress  Whether to compress image
     * @param  bool  $createThumbnail  Whether to create thumbnail
     * @return string Stored file path
     *
     * @throws ImageProcessingException
     */
    public function storeBase64Image(
        string $base64Data,
        ?string $folder = null,
        bool $compress = true,
        bool $createThumbnail = false
    ): string {
        $folder = $folder ?? config('buku_tamu.upload.storage_path');

        // Extract and validate extension
        $extension = $this->extractExtension($base64Data);
        $this->validateExtension($extension);

        // Clean and decode base64 data
        $binaryData = $this->decodeBase64($base64Data);

        // Security validations
        $this->validateImageSize($binaryData);
        $this->validateIsActuallyImage($binaryData);

        // Generate secure filename
        $filename = $this->generateSecureFilename($extension);
        $filePath = "{$folder}/{$filename}";

        try {
            // Process image with Intervention Image
            $image = Image::read($binaryData);

            // Compress image if requested
            if ($compress) {
                // Resize if too large
                if ($image->width() > 1920 || $image->height() > 1920) {
                    $image->scale(width: 1920, height: 1920);
                }

                // Encode with compression (80% quality for JPG/WebP)
                $binaryData = $image->encode(new \Intervention\Image\Encoders\AutoEncoder(quality: 80))->toString();
            }

            // Store main image
            Storage::disk('public')->put($filePath, $binaryData);

            // Create thumbnail if requested
            if ($createThumbnail) {
                $this->createThumbnail($image, $folder, $filename);
            }
        } catch (\Exception $e) {
            throw ImageProcessingException::storageFailed();
        }

        return $filePath;
    }

    /**
     * Create thumbnail from image.
     */
    private function createThumbnail($image, string $folder, string $filename): void
    {
        $thumbnailFolder = $folder . '/thumbnails';
        $thumbnailPath = "{$thumbnailFolder}/{$filename}";

        // Create thumbnail (300x300)
        $thumbnail = clone $image;
        $thumbnail->cover(300, 300);

        // Store thumbnail
        Storage::disk('public')->put(
            $thumbnailPath,
            $thumbnail->encode(quality: 75)->toString()
        );
    }

    /**
     * Store base64 image with organized directory structure (year/month).
     *
     * @throws ImageProcessingException
     */
    public function storeWithDateStructure(string $base64Data): string
    {
        $baseFolder = config('buku_tamu.upload.photo_path_prefix');
        $dateFolder = date('Y/m');
        $folder = "{$baseFolder}/{$dateFolder}";

        return $this->storeBase64Image($base64Data, $folder);
    }

    /**
     * Extract file extension from base64 data URL.
     */
    private function extractExtension(string $base64Data): string
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $matches)) {
            $extension = strtolower($matches[1]);

            // Normalize extension variations
            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }

            return $extension;
        }

        // If no extension found, try to detect from data
        throw ImageProcessingException::invalidBase64();
    }

    /**
     * Validate image extension against whitelist.
     *
     * @throws ImageProcessingException
     */
    private function validateExtension(string $extension): void
    {
        $allowedExtensions = config('buku_tamu.upload.allowed_extensions');

        if (! in_array($extension, $allowedExtensions)) {
            throw ImageProcessingException::invalidFormat();
        }
    }

    /**
     * Decode base64 string with security checks.
     *
     * @throws ImageProcessingException
     */
    private function decodeBase64(string $base64Data): string
    {
        // Remove data URL prefix if exists
        if (strpos($base64Data, 'data:image') === 0) {
            $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
        }

        // Remove whitespace
        $base64Data = preg_replace('/\s+/', '', $base64Data);

        // Validate base64 format
        if (! preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $base64Data)) {
            throw ImageProcessingException::invalidBase64();
        }

        $binaryData = base64_decode($base64Data, true);

        if ($binaryData === false) {
            throw ImageProcessingException::invalidBase64();
        }

        return $binaryData;
    }

    /**
     * Validate image size.
     *
     * @throws ImageProcessingException
     */
    private function validateImageSize(string $binaryData): void
    {
        $maxSizeMb = config('buku_tamu.upload.max_size_mb', 5);
        $maxSizeBytes = $maxSizeMb * 1024 * 1024;

        if (strlen($binaryData) > $maxSizeBytes) {
            throw ImageProcessingException::tooLarge($maxSizeMb);
        }

        // Minimum size check (prevent empty/tiny files)
        if (strlen($binaryData) < 100) {
            throw ImageProcessingException::corruptData();
        }
    }

    /**
     * Validate that binary data is actually an image.
     *
     * @throws ImageProcessingException
     */
    private function validateIsActuallyImage(string $binaryData): void
    {
        // Try to create image resource from string
        $imageResource = @imagecreatefromstring($binaryData);

        if ($imageResource === false) {
            throw ImageProcessingException::corruptData();
        }

        // Clean up resource
        imagedestroy($imageResource);

        // Additional check: validate magic bytes (file signature)
        $this->validateMagicBytes($binaryData);
    }

    /**
     * Validate file magic bytes to ensure it's a real image.
     *
     * @throws ImageProcessingException
     */
    private function validateMagicBytes(string $binaryData): void
    {
        $magicBytes = substr($binaryData, 0, 4);

        // Known image file signatures
        $validSignatures = [
            "\xFF\xD8\xFF", // JPEG
            "\x89PNG", // PNG
            'GIF8', // GIF
            'RIFF', // WebP (starts with RIFF)
        ];

        $isValid = false;
        foreach ($validSignatures as $signature) {
            if (strpos($magicBytes, $signature) === 0) {
                $isValid = true;

                break;
            }
        }

        if (! $isValid) {
            throw ImageProcessingException::corruptData();
        }
    }

    /**
     * Generate secure random filename using UUID.
     */
    private function generateSecureFilename(string $extension): string
    {
        // Use UUID for unpredictable filenames (security best practice)
        return Str::uuid() . '.' . $extension;
    }

    /**
     * Delete image file from storage.
     */
    public function deleteImage(?string $filePath): bool
    {
        if (! $filePath || ! Storage::disk('public')->exists($filePath)) {
            return false;
        }

        return Storage::disk('public')->delete($filePath);
    }
}
