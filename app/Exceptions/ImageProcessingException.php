<?php

namespace App\Exceptions;

use Exception;

class ImageProcessingException extends Exception
{
    /**
     * Create a new exception for invalid image format.
     */
    public static function invalidFormat(): self
    {
        return new self('Format gambar tidak valid. Hanya menerima format JPEG, PNG, atau WebP.', 400);
    }

    /**
     * Create a new exception for image too large.
     */
    public static function tooLarge(int $maxSizeMB = 5): self
    {
        return new self("Ukuran gambar terlalu besar. Maksimal {$maxSizeMB}MB.", 400);
    }

    /**
     * Create a new exception for corrupt image data.
     */
    public static function corruptData(): self
    {
        return new self('Data gambar rusak atau tidak dapat diproses. Silakan coba gambar lain.', 400);
    }

    /**
     * Create a new exception for storage failure.
     */
    public static function storageFailed(): self
    {
        return new self('Gagal menyimpan gambar. Silakan coba lagi.', 500);
    }

    /**
     * Create a new exception for invalid base64 encoding.
     */
    public static function invalidBase64(): self
    {
        return new self('Format base64 gambar tidak valid.', 400);
    }
}
