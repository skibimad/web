<?php

return [
    'driver' => getenv('DB_DRIVER') ?: 'sqlite',
    'host' => getenv('DB_HOST') ?: 'localhost',
    'database' => getenv('DB_NAME') ?: __DIR__ . '/../database/skibidi_madness.db',
    'username' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASS') ?: '',
    'charset' => 'utf8mb4',
];
