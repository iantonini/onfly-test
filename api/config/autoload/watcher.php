<?php

declare(strict_types=1);
use function Hyperf\Support\env;

return [
    'enable' => env('WATCHER_ENABLED', true),
    'driver' => Hyperf\Watcher\Driver\ScanFileDriver::class,
    'bin' => 'php',
    'watch' => [
        'dir' => ['app', 'config'],
        'file' => ['.php'],
        'scan_interval' => env('WATCHER_ENABLED', 1000),
    ],
];
