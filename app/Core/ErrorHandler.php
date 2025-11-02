<?php

namespace App\Core;

/**
 * Error Handler - Handles exceptions and errors with custom pages
 */
class ErrorHandler
{
    private static array $heroImages = [
        '/res/img/heroes/promo/titan-camera.png',
        '/res/img/heroes/promo/titan-speaker.png',
        '/res/img/heroes/promo/titan-tv.png',
        '/res/img/heroes/promo/g-man.png',
        '/res/img/heroes/promo/star-storage.png',
    ];
    
    /**
     * Handle 404 Not Found
     */
    public static function handle404(): void
    {
        http_response_code(404);
        $heroImage = self::getRandomHeroImage();
        require __DIR__ . '/../Views/errors/404.phtml';
        exit;
    }
    
    /**
     * Handle 500 Internal Server Error
     */
    public static function handle500(\Throwable $exception = null): void
    {
        http_response_code(500);
        $heroImage = self::getRandomHeroImage();
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
        $heroImage = self::getRandomHeroImage();
        require __DIR__ . '/../Views/errors/generic.phtml';
        exit;
    }
    
    /**
     * Get random hero image
     */
    private static function getRandomHeroImage(): string
    {
        return self::$heroImages[array_rand(self::$heroImages)];
    }
    
    /**
     * Register global error and exception handlers
     */
    public static function register(): void
    {
        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handleError']);
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
