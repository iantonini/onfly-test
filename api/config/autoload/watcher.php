<?php

return [
    'enabled' => true, //env('WATCHER_ENABLED', true),
    'watch' => [
        'directories' => [
            'app',
            'config',
        ],
        'file_types' => [
            'php',
        ],
    ],
    'interval' => 1.0, //env('WATCHER_INTERVAL', 1.0),
];