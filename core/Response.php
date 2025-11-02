<?php

namespace Core;

/**
 * Response - HTTP Response helper
 */
class Response {
    /**
     * Send JSON response
     */
    public static function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Redirect to URL
     */
    public static function redirect($url) {
        header("Location: {$url}");
        exit;
    }
    
    /**
     * Send 404 response
     */
    public static function notFound() {
        http_response_code(404);
        echo "404 - Page Not Found";
        exit;
    }
    
    /**
     * Send error response
     */
    public static function error($message, $statusCode = 500) {
        http_response_code($statusCode);
        echo "Error: {$message}";
        exit;
    }
    
    /**
     * Set status code
     */
    public static function status($code) {
        http_response_code($code);
        return new self();
    }
}
