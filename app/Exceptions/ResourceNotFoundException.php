<?php

namespace App\Exceptions;

use Exception;

class ResourceNotFoundException extends Exception
{
    /**
     * Create a new exception for resource not found.
     */
    public static function make(string $resource = 'Data'): self
    {
        return new self("{$resource} tidak ditemukan.", 404);
    }

    /**
     * Create a new exception for visitor not found.
     */
    public static function visitor(): self
    {
        return self::make('Pengunjung');
    }

    /**
     * Create a new exception for tournament not found.
     */
    public static function tournament(): self
    {
        return self::make('Turnamen');
    }

    /**
     * Create a new exception for news not found.
     */
    public static function news(): self
    {
        return self::make('Berita');
    }

    /**
     * Create a new exception for event not found.
     */
    public static function event(): self
    {
        return self::make('Event');
    }

    /**
     * Create a new exception for admin not found.
     */
    public static function admin(): self
    {
        return self::make('Admin');
    }
}
