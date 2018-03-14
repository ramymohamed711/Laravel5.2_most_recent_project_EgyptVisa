<?php

return [
    'oracle' => [
    'driver'        => 'oracle',
    'tns'           => env('DB_TNS', '192.168.163.88:1521/blacme'),
    'host'          => env('DB_HOST', '192.168.163.88'),
    'port'          => env('DB_PORT', '1521'),
    'database'      => env('DB_DATABASE', 'blacme'),
    'username'      => env('DB_USERNAME', 'orchestrator'),
    'password'      => env('DB_PASSWORD', 'orc'),
    'charset'       => env('DB_CHARSET', 'AL32UTF8'),
    'prefix'        => env('DB_PREFIX', ''),
    'prefix_schema' => env('DB_SCHEMA_PREFIX', ''),
    ],
];
