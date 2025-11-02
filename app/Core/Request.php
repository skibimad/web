<?php

namespace App\Core;

/**
 * Request class - handles HTTP request data
 */
class Request
{
    private $uri;
    private $method;
    private $params = [];
    private $query = [];
    private $post = [];
    
    public function __construct()
    {
        $this->uri = $this->parseUri();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->query = $_GET;
        $this->post = $_POST;
    }
    
    private function parseUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        
        // Remove trailing slash
        $uri = rtrim($uri, '/');
        
        // Ensure leading slash
        if (empty($uri)) {
            $uri = '/';
        } elseif ($uri[0] !== '/') {
            $uri = '/' . $uri;
        }
        
        return $uri;
    }
    
    public function uri(): string
    {
        return $this->uri;
    }
    
    public function getUri(): string
    {
        return $this->uri;
    }
    
    public function getMethod(): string
    {
        return $this->method;
    }
    
    public function get(string $key, $default = null)
    {
        return $this->query[$key] ?? $default;
    }
    
    public function post(string $key, $default = null)
    {
        return $this->post[$key] ?? $default;
    }
    
    public function input(string $key, $default = null)
    {
        return $this->post[$key] ?? $this->query[$key] ?? $default;
    }
    
    public function all(): array
    {
        return array_merge($this->query, $this->post);
    }
    
    public function setParams(array $params): void
    {
        $this->params = $params;
    }
    
    public function param(string $key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }
}
