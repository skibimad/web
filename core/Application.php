<?php

/**
 * Application Bootstrap
 * Handles initialization, autoloading, and application lifecycle
 */
class Application {
    private static $instance = null;
    private $router;
    private $config;
    
    private function __construct() {
        $this->config = require_once __DIR__ . '/../config/config.php';
        $this->registerAutoloader();
        $this->initializeSession();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Register PSR-4 style autoloader
     */
    private function registerAutoloader() {
        spl_autoload_register(function ($class) {
            $paths = [
                __DIR__ . '/../app/Controllers/',
                __DIR__ . '/../app/Controllers/Admin/',
                __DIR__ . '/../app/Models/',
                __DIR__ . '/../core/',
            ];
            
            foreach ($paths as $path) {
                $file = $path . $class . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        });
    }
    
    /**
     * Initialize session
     */
    private function initializeSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Run the application
     */
    public function run() {
        $this->router = new Router();
        $routes = require __DIR__ . '/../config/routes.php';
        $routes($this->router);
        
        $this->router->dispatch();
    }
    
    /**
     * Get configuration value
     */
    public function config($key, $default = null) {
        return $this->config[$key] ?? $default;
    }
}
