<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Pagination Settings
    |--------------------------------------------------------------------------
    |
    | This file contains all pagination constants used throughout the application
    | to avoid magic numbers and maintain consistency.
    |
    */

    // Web Views Pagination
    'web' => [
        'default' => 10,
        'events' => 12,
        'tournaments' => 9,
        'news' => 9,
    ],

    // Admin Panel Pagination
    'admin' => [
        'default' => 10,
        'events' => 15,
        'tournaments' => 10,
        'news' => 10,
    ],

    // API Pagination
    'api' => [
        'default' => 10,
        'statistics_limit' => 12,
    ],
];
