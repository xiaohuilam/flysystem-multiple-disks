<?php

return [
    'disks' => [

        'public' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public'),
            'url'        => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key'    => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

        'multi' => [
            'driver' => 'multi',
            'disks'  => env('FILESYSTEM_MULTI_DISKS') ? explode(',', env('FILESYSTEM_MULTI_DISKS')) : [
                'public',
                's3',
            ],
            'url'   => env('FILESYSTEM_MULTI_URI', config('app.url')),
        ],

    ],

];
