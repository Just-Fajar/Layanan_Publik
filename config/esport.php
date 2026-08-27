<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Tournament Configuration
    |--------------------------------------------------------------------------
    */
    'tournament' => [
        'statuses' => [
            'upcoming' => 'Upcoming',
            'ongoing' => 'Ongoing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ],

        'games' => [
            'mobile_legends' => 'Mobile Legends',
            'pubg_mobile' => 'PUBG Mobile',
            'free_fire' => 'Free Fire',
            'valorant' => 'Valorant',
            'dota2' => 'Dota 2',
            'csgo' => 'CS:GO',
            'other' => 'Other',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | News Configuration
    |--------------------------------------------------------------------------
    */
    'news' => [
        'categories' => [
            'Pengumuman' => 'Pengumuman',
            'Tournament Info' => 'Tournament Info',
            'Esport News' => 'Esport News',
        ],

        'statuses' => [
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Upload Configuration
    |--------------------------------------------------------------------------
    */
    'upload' => [
        'tournament_image' => [
            'max_size_mb' => 5,
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
            'storage_path' => 'tournaments',
        ],

        'news_image' => [
            'max_size_mb' => 5,
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
            'storage_path' => 'news',
        ],
    ],

    'games' => [
        'mobile_legends' => 'Mobile Legends',
        'pubg_mobile' => 'PUBG Mobile',
        'free_fire' => 'Free Fire',
        'valorant' => 'Valorant',
        'dota2' => 'Dota 2',
        'csgo' => 'CS:GO',
        'other' => 'Other',
    ],

    'tournament_statuses' => [
        'upcoming' => 'Upcoming',
        'ongoing' => 'Ongoing',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ],

    'news_categories' => [
        'Pengumuman' => 'Pengumuman',
        'Tournament Info' => 'Tournament Info',
        'Esport News' => 'Esport News',
    ],

    'news_statuses' => [
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ],
];
