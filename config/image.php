<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */
    'driver' => env('IMAGE_DRIVER', 'gd'),
    
    'cache' => [
        'enabled' => true,
        'path' => storage_path('app/image-cache'),
        'lifetime' => 2628000, // 1 month
    ],
    
    'optimization' => [
        'jpeg_quality' => 85,
        'webp_quality' => 85,
        'png_compression' => 9,
    ],

];
