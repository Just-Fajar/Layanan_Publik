<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Event Categories
    |--------------------------------------------------------------------------
    */
    'categories' => [
        'workshop' => 'Workshop',
        'seminar' => 'Seminar',
        'training' => 'Pelatihan',
        'conference' => 'Konferensi',
        'competition' => 'Kompetisi',
        'exhibition' => 'Pameran',
        'other' => 'Lainnya',
    ],

    /*
    |--------------------------------------------------------------------------
    | Event Statuses
    |--------------------------------------------------------------------------
    */
    'statuses' => [
        'draft' => 'Draft',
        'published' => 'Published',
        'cancelled' => 'Cancelled',
        'completed' => 'Completed',
    ],

    /*
    |--------------------------------------------------------------------------
    | Status Badge Configuration
    |--------------------------------------------------------------------------
    */
    'status_badges' => [
        'draft' => '<span class="badge bg-secondary">Draft</span>',
        'published' => '<span class="badge bg-success">Published</span>',
        'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
        'completed' => '<span class="badge bg-info">Completed</span>',
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Upload Configuration
    |--------------------------------------------------------------------------
    */
    'upload' => [
        'max_size_mb' => 5,
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
        'storage_path' => 'events',
    ],

    /*
    |--------------------------------------------------------------------------
    | Event Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'max_participants' => null, // null = unlimited
        'is_public' => true,
        'registration_days_before' => 7, // Registration deadline default
    ],
];
