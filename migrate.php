#!/usr/bin/env php
<?php

// Load .env file if it exists
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        if (!array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Migration;

echo "🚀 Running database migrations...\n\n";

$migration = new Migration();

try {
    $executed = $migration->migrate();
    
    if (empty($executed)) {
        echo "✅ Database is up to date. No migrations to run.\n";
    } else {
        echo "✅ Successfully executed migrations:\n";
        foreach ($executed as $name) {
            echo "   - $name\n";
        }
    }
    
    $currentVersion = $migration->getCurrentVersion();
    echo "\n📊 Current database version: $currentVersion\n";
    
} catch (\Exception $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n✨ Migration complete!\n";
