<?php

namespace App\Core;

class Request
{
    private $uri;
    private $method;
    private $params;
    private $body;
    
    public function __construct()
    {
        $this->uri = $this->parseUri();
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->params = $_GET;
        $this->body = $this->parseBody();
    }
    
    private function parseUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Remove query string
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }
        
        // Remove trailing slash except for root
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }
        
        return $uri;
    }
    
    private function parseBody(): array
    {
        if ($this->method === 'POST' || $this->method === 'PUT') {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            
            if (strpos($contentType, 'application/json') !== false) {
                return json_decode(file_get_contents('php://input'), true) ?? [];
            }
            
            return $_POST;
        }
        
        return [];
    }
    
    public function getUri(): string
    {
        return $this->uri;
    }
    
    public function getMethod(): string
    {
        return $this->method;
    }
    
    public function getParams(): array
    {
        return $this->params;
    }
    
    public function getParam(string $key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }
    
    public function getBody(): array
    {
        return $this->body;
    }
    
    public function input(string $key, $default = null)
    {
        return $this->body[$key] ?? $default;
    }
    
    public function all(): array
    {
        return array_merge($this->params, $this->body);
    }
    
    public function file(string $key)
    {
        return $_FILES[$key] ?? null;
    }
    
    public function hasFile(string $key): bool
    {
        return isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK;
    }
    
    public function isPost(): bool
    {
        return $this->method === 'POST';
    }
    
    public function isGet(): bool
    {
        return $this->method === 'GET';
    }
}
