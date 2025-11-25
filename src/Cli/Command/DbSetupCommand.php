<?php

namespace App\Cli\Command;

use App\Cli\AbstractCommand;
use App\Cli\Migration;
use App\Core\Config;
use App\Core\Database;

/**
 * Command to set up the database using etc/db/setup.sql or setup.php.
 */
class DbSetupCommand extends AbstractCommand
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'db:setup';
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return 'Set up the database schema (runs etc/db/setup.sql or setup.php)';
    }

    /**
     * @inheritDoc
     */
    public function execute(array $args = []): int
    {
        $root = Config::get('root');
        $setupPath = $root . 'etc/db/';

        $this->info('Starting database setup...');

        // Check for setup.php first, then setup.sql
        $migration = new Migration($setupPath);

        $phpFile = $setupPath . 'setup.php';
        $sqlFile = $setupPath . 'setup.sql';

        $executed = false;

        if (file_exists($phpFile)) {
            $this->output("Executing: $phpFile");
            if ($migration->executePhpFile($phpFile)) {
                $executed = true;
            } else {
                $this->error("Failed to execute: $phpFile");
                return 1;
            }
        }

        if (file_exists($sqlFile)) {
            $this->output("Executing: $sqlFile");
            if ($migration->executeSqlFile($sqlFile)) {
                $executed = true;
            } else {
                $this->error("Failed to execute: $sqlFile");
                return 1;
            }
        }

        if (!$executed) {
            $this->warning("No setup file found at $setupPath (setup.sql or setup.php)");
            return 0;
        }

        $this->success('Database setup completed successfully!');
        return 0;
    }
}
