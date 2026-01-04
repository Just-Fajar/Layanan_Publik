<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Buku Tamu Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains all configuration related to the Buku Tamu (Visitor Book) module
    |
    */

    // Geolocation Settings
    'geolocation' => [
        'target_latitude' => -7.632269349111827,
        'target_longitude' => 111.5301320107111,
        'max_distance_km' => 0.5, // 500 meters radius
        'earth_radius_km' => 6371, // Earth's radius for Haversine formula
    ],

    // Purpose Options
    'purpose_options' => [
        'sekretariat' => 'Sekretariat',
        'aplikasi_informatika' => 'Aplikasi Informatika',
        'persandian_keamanan_informasi' => 'Persandian dan Keamanan Informasi',
        'informasi_komunikasi_publik' => 'Informasi Komunikasi Publik',
        'statistik' => 'Statistik',
    ],

    // Image Upload Settings
    'upload' => [
        'max_size_mb' => 5,
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
        'storage_path' => 'visitors',
        'photo_path_prefix' => 'photos',
    ],

    // Date Format
    'date_format' => 'Y-m-d H:i:s',
];
