<?php

namespace App\Exceptions;

use Exception;

class GeolocationException extends Exception
{
    /**
     * Create a new exception for location out of range.
     */
    public static function outOfRange(): self
    {
        return new self('Lokasi Anda berada di luar area yang diizinkan. Pastikan Anda berada di dalam gedung atau area yang ditentukan.', 403);
    }

    /**
     * Create a new exception for invalid coordinates.
     */
    public static function invalidCoordinates(): self
    {
        return new self('Koordinat lokasi tidak valid. Pastikan GPS Anda aktif dan memberikan data yang akurat.', 400);
    }

    /**
     * Create a new exception for location permission denied.
     */
    public static function permissionDenied(): self
    {
        return new self('Akses lokasi ditolak. Izinkan aplikasi mengakses lokasi Anda untuk melanjutkan.', 403);
    }

    /**
     * Create a new exception for location service unavailable.
     */
    public static function serviceUnavailable(): self
    {
        return new self('Layanan lokasi tidak tersedia. Aktifkan GPS pada perangkat Anda.', 503);
    }
}
