<?php

namespace App\Core;

/**
 * Error Handler - Handles exceptions and errors with custom pages
 */
class ErrorHandler
{
    /**
     * Get random background video from fun folder
     */
    private static function getRandomVideo(): ?string
    {
        $videoPath = __DIR__ . '/../../res/video/fun/';
        
        if (!is_dir($videoPath)) {
            return null;
        }
        
        $videos = glob($videoPath . '*.{mp4,webm,mov}', GLOB_BRACE);
        
        if (empty($videos)) {
            return null;
        }
        
        $randomVideo = $videos[array_rand($videos)];
        return str_replace(__DIR__ . '/../../', '/', $randomVideo);
    }
    
    /**
     * Handle 404 Not Found
     */
    public static function handle404(): void
    {
        http_response_code(404);
        $backgroundVideo = self::getRandomVideo();
        require __DIR__ . '/../Views/errors/404.phtml';
        exit;
    }
    
    /**
     * Handle 500 Internal Server Error
     */
    public static function handle500(\Throwable $exception = null): void
    {
        http_response_code(500);
        $backgroundVideo = self::getRandomVideo();
        $errorMessage = $exception ? $exception->getMessage() : 'An unexpected error occurred';
        $errorTrace = $exception ? $exception->getTraceAsString() : '';
        
        // Log error in development mode
        if (ini_get('display_errors')) {
            error_log("Error 500: " . $errorMessage);
            if ($errorTrace) {
                error_log($errorTrace);
            }
        }
        
        require __DIR__ . '/../Views/errors/500.phtml';
        exit;
    }
    
    /**
     * Handle generic errors
     */
    public static function handleError(int $code, string $message = ''): void
    {
        http_response_code($code);
        $backgroundVideo = self::getRandomVideo();
        require __DIR__ . '/../Views/errors/generic.phtml';
        exit;
    }
    
    /**
     * Register global error and exception handlers
     */
    public static function register(): void
    {
        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handlePhpError']);
        register_shutdown_function([self::class, 'handleFatalError']);
    }
    
    /**
     * Handle uncaught exceptions
     */
    public static function handleException(\Throwable $exception): void
    {
        self::handle500($exception);
    }
    
    /**
     * Handle PHP errors
     */
    public static function handlePhpError(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        // Don't handle suppressed errors
        if (!(error_reporting() & $errno)) {
            return false;
        }
        
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
    
    /**
     * Handle fatal errors
     */
    public static function handleFatalError(): void
    {
        $error = error_get_last();
        if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            self::handle500();
        }
    }
}
