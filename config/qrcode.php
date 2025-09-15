<?php

return [
    // Paksa pakai GD, bukan Imagick
    'image_backend' => env('QRCODE_IMAGE_BACKEND', 'gd'),
];
