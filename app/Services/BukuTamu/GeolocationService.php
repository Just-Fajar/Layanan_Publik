<?php

namespace App\Services\BukuTamu;

class GeolocationService
{
    /**
     * Check if given coordinates are within allowed range from target location.
     */
    public function isWithinRange(?float $latitude, ?float $longitude): bool
    {
        if (! $latitude || ! $longitude) {
            return false;
        }

        $distance = $this->calculateDistance(
            config('buku_tamu.geolocation.target_latitude'),
            config('buku_tamu.geolocation.target_longitude'),
            $latitude,
            $longitude
        );

        return $distance <= config('buku_tamu.geolocation.max_distance_km');
    }

    /**
     * Calculate distance between two coordinates using Haversine formula.
     *
     * @return float Distance in kilometers
     */
    private function calculateDistance(float $latFrom, float $lonFrom, float $latTo, float $lonTo): float
    {
        $earthRadius = config('buku_tamu.geolocation.earth_radius_km');

        $latFrom = deg2rad($latFrom);
        $lonFrom = deg2rad($lonFrom);
        $latTo = deg2rad($latTo);
        $lonTo = deg2rad($lonTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
        ));

        return $angle * $earthRadius;
    }

    /**
     * Validate location and throw exception if out of range.
     *
     * @throws \Exception
     */
    public function validateLocation(?float $latitude, ?float $longitude): void
    {
        if (! $this->isWithinRange($latitude, $longitude)) {
            throw new \Exception('Maaf, Anda berada di luar area yang diizinkan. Silahkan datang ke lokasi untuk mengisi buku tamu.');
        }
    }
}
