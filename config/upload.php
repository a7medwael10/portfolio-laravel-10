<?php

return [
    'driver' => env('UPLOAD_DRIVER', 'public'),

    'max_size' => env('UPLOAD_MAX_SIZE', 2048),

    'default_directory' => 'avatars',

    'drivers' => [
        'public' => [
            'path' => public_path(),
        ],

        'storage' => [
            'disk' => 'public',
        ],
    ],
];
