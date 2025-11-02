<?php

namespace App\Core;

/**
 * Database Migration System
 * Handles automated schema versioning and updates
 */
class Migration
{
    private Database $db;
    private string $migrationsPath;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->migrationsPath = __DIR__ . '/../../database/migrations/';
    }

    /**
     * Initialize migrations table
     */
    public function init(): void
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                version INT NOT NULL UNIQUE,
                name VARCHAR(255) NOT NULL,
                executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }

    /**
     * Get current database version
     */
    public function getCurrentVersion(): int
    {
        $this->init();
        $result = $this->db->query("SELECT MAX(version) as version FROM migrations")->fetch();
        return (int)($result['version'] ?? 0);
    }

    /**
     * Run all pending migrations
     */
    public function migrate(): array
    {
        $currentVersion = $this->getCurrentVersion();
        $migrations = $this->getPendingMigrations($currentVersion);
        $executed = [];

        foreach ($migrations as $migration) {
            try {
                $this->executeMigration($migration);
                $executed[] = $migration['name'];
            } catch (\Exception $e) {
                throw new \RuntimeException("Migration failed: {$migration['name']} - " . $e->getMessage());
            }
        }

        return $executed;
    }

    /**
     * Get list of pending migrations
     */
    private function getPendingMigrations(int $currentVersion): array
    {
        $migrations = [];
        
        if (!is_dir($this->migrationsPath)) {
            mkdir($this->migrationsPath, 0755, true);
            return [];
        }

        $files = scandir($this->migrationsPath);
        foreach ($files as $file) {
            if (preg_match('/^(\d+)_(.+)\.sql$/', $file, $matches)) {
                $version = (int)$matches[1];
                if ($version > $currentVersion) {
                    $migrations[] = [
                        'version' => $version,
                        'name' => $matches[2],
                        'file' => $file
                    ];
                }
            }
        }

        usort($migrations, fn($a, $b) => $a['version'] <=> $b['version']);
        return $migrations;
    }

    /**
     * Execute a single migration
     */
    private function executeMigration(array $migration): void
    {
        $sql = file_get_contents($this->migrationsPath . $migration['file']);
        
        // Execute the migration SQL
        $this->db->getPdo()->exec($sql);
        
        // Record the migration
        $this->db->query(
            "INSERT INTO migrations (version, name) VALUES (?, ?)",
            [$migration['version'], $migration['name']]
        );
    }

    /**
     * Create a new migration file
     */
    public function create(string $name): string
    {
        if (!is_dir($this->migrationsPath)) {
            mkdir($this->migrationsPath, 0755, true);
        }

        $version = time();
        $filename = sprintf('%d_%s.sql', $version, $name);
        $filepath = $this->migrationsPath . $filename;

        $template = "-- Migration: {$name}\n-- Version: {$version}\n-- Created: " . date('Y-m-d H:i:s') . "\n\n";
        $template .= "-- Add your SQL statements here\n\n";

        file_put_contents($filepath, $template);
        return $filename;
    }
}
