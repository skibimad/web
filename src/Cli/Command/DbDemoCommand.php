<?php

namespace App\Cli\Command;

use App\Cli\AbstractCommand;
use App\Cli\Migration;
use App\Core\Config;

/**
 * Command to load demo data into the database.
 */
class DbDemoCommand extends AbstractCommand
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'db:demo';
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return 'Load demo data into the database (runs etc/db/demo.sql or demo.php)';
    }

    /**
     * @inheritDoc
     */
    public function execute(array $args = []): int
    {
        $root = Config::get('root');
        $demoPath = $root . 'etc/db/';

        $this->info('Loading demo data...');

        $migration = new Migration($demoPath);

        $phpFile = $demoPath . 'demo.php';
        $sqlFile = $demoPath . 'demo.sql';

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
            $this->warning("No demo file found at $demoPath (demo.sql or demo.php)");
            return 0;
        }

        $this->success('Demo data loaded successfully!');
        return 0;
    }
}
