<?php

namespace App\Cli\Command;

use App\Cli\AbstractCommand;
use App\Core\Config;

/**
 * Command to update local copies of external CSS/JS libraries.
 *
 * This command downloads external CSS/JS files from CDNs and stores them locally
 * to avoid issues with external resource availability.
 */
class ResourceExternalUpdateCommand extends AbstractCommand
{
    /**
     * External resources configuration.
     *
     * Each entry contains:
     * - url: The CDN URL to download from
     * - local: The local path (relative to public directory)
     */
    private array $resources = [
        // Font Awesome CSS
        [
            'url' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
            'local' => 'css/external/font-awesome.min.css',
        ],
        // jQuery
        [
            'url' => 'https://code.jquery.com/jquery-3.6.0.min.js',
            'local' => 'js/external/jquery.min.js',
        ],
        // Summernote CSS
        [
            'url' => 'https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css',
            'local' => 'css/external/summernote-lite.min.css',
        ],
        // Summernote JS
        [
            'url' => 'https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js',
            'local' => 'js/external/summernote-lite.min.js',
        ],
    ];

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'resource:external:update';
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return 'Update local copies of external CSS/JS libraries from CDNs';
    }

    /**
     * @inheritDoc
     */
    public function execute(array $args = []): int
    {
        $root = Config::get('root');
        $publicDir = $root . 'public/';

        $this->info('Updating local copies of external resources...');
        $this->output('');

        // Ensure external directories exist
        $this->ensureDirectoryExists($publicDir . 'css/external');
        $this->ensureDirectoryExists($publicDir . 'js/external');

        $success = true;
        $updated = 0;
        $failed = 0;

        foreach ($this->resources as $resource) {
            $url = $resource['url'];
            $localPath = $publicDir . $resource['local'];

            $this->output("Downloading: {$url}");

            try {
                $content = $this->downloadFile($url);

                if ($content === false) {
                    $this->error("  Failed to download: {$url}");
                    $success = false;
                    $failed++;
                    continue;
                }

                if (file_put_contents($localPath, $content) === false) {
                    $this->error("  Failed to save: {$localPath}");
                    $success = false;
                    $failed++;
                    continue;
                }

                $size = strlen($content);
                $this->success("  Saved to: {$resource['local']} ({$size} bytes)");
                $updated++;
            } catch (\Exception $e) {
                $this->error("  Error: " . $e->getMessage());
                $success = false;
                $failed++;
            }
        }

        $this->output('');

        if ($success) {
            $this->success("All external resources updated successfully! ({$updated} files)");
            return 0;
        } else {
            $this->warning("Completed with errors. Updated: {$updated}, Failed: {$failed}");
            return 1;
        }
    }

    /**
     * Ensure a directory exists, creating it if necessary.
     *
     * @param string $dir Directory path
     * @return void
     */
    private function ensureDirectoryExists(string $dir): void
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0750, true);
            $this->info("Created directory: {$dir}");
        }
    }

    /**
     * Download a file from a URL.
     *
     * @param string $url The URL to download from
     * @return string|false The file content or false on failure
     */
    private function downloadFile(string $url)
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 30,
                'user_agent' => 'Mozilla/5.0 (compatible; SkibidiMadness/1.0)',
                'follow_location' => false,
            ],
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
            ],
        ]);

        // Suppress warnings during download, but capture error info for network-related issues
        $errorMessage = null;
        set_error_handler(function($errno, $errstr) use (&$errorMessage) {
            // Only handle warnings (E_WARNING) which are expected from network errors
            if ($errno === E_WARNING) {
                $errorMessage = $errstr;
                return true;
            }
            return false; // Let other error types be handled normally
        }, E_WARNING);

        $content = file_get_contents($url, false, $context);

        // $http_response_header is populated by PHP after file_get_contents() with HTTP URLs
        $responseHeaders = $http_response_header ?? [];

        restore_error_handler();

        if ($content === false) {
            if (!empty($responseHeaders)) {
                $this->warning("  HTTP Response: " . $responseHeaders[0]);
            } elseif ($errorMessage) {
                // Extract meaningful part of error message
                if (preg_match('/getaddrinfo|network|connection|timeout/i', $errorMessage)) {
                    $this->warning("  Network error (host unreachable or timeout)");
                }
            }
        }

        return $content;
    }
}
