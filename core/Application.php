<?php

namespace Core;

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
        $this->initializeSession();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
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
