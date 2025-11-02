#!/usr/bin/env php
<?php

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
