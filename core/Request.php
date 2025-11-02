<?php

namespace Core;

/**
 * Request - HTTP Request wrapper
 */
class Request {
    private $data = [];
    
    public function __construct() {
        $this->data = array_merge($_GET, $_POST);
    }
    
    /**
     * Get request method
     */
    public function method() {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    /**
     * Get request URI
     */
    public function uri() {
        $uri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }
        
        return $uri;
    }
    
    /**
     * Get all input data
     */
    public function all() {
        return $this->data;
    }
    
    /**
     * Get specific input value
     */
    public function get($key, $default = null) {
        return $this->data[$key] ?? $default;
    }
    
    /**
     * Get POST value
     */
    public function post($key, $default = null) {
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Get uploaded file
     */
    public function file($key) {
        return $_FILES[$key] ?? null;
    }
    
    /**
     * Check if request has key
     */
    public function has($key) {
        return isset($this->data[$key]);
    }
    
    /**
     * Get session value
     */
    public function session($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
}
