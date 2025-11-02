<?php

/**
 * Router - Handles URL routing and dispatching
 */
class Router {
    private $routes = [];
    private $middlewares = [];
    
    /**
     * Add a GET route
     */
    public function get($uri, $action, $middleware = []) {
        $this->addRoute('GET', $uri, $action, $middleware);
    }
    
    /**
     * Add a POST route
     */
    public function post($uri, $action, $middleware = []) {
        $this->addRoute('POST', $uri, $action, $middleware);
    }
    
    /**
     * Add a route
     */
    private function addRoute($method, $uri, $action, $middleware) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action,
            'middleware' => $middleware
        ];
    }
    
    /**
     * Register middleware
     */
    public function middleware($name, $callback) {
        $this->middlewares[$name] = $callback;
    }
    
    /**
     * Dispatch the request
     */
    public function dispatch() {
        $request = new Request();
        $method = $request->method();
        $uri = $request->uri();
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            
            $pattern = $this->convertToPattern($route['uri']);
            if (preg_match($pattern, $uri, $matches)) {
                // Run middleware
                foreach ($route['middleware'] as $middleware) {
                    if (isset($this->middlewares[$middleware])) {
                        call_user_func($this->middlewares[$middleware], $request);
                    }
                }
                
                // Extract parameters
                array_shift($matches);
                
                // Call controller action
                return $this->callAction($route['action'], $matches, $request);
            }
        }
        
        // 404 Not Found
        Response::notFound();
    }
    
    /**
     * Convert route URI to regex pattern
     */
    private function convertToPattern($uri) {
        $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $uri);
        return '#^' . $pattern . '$#';
    }
    
    /**
     * Call controller action
     */
    private function callAction($action, $params, $request) {
        list($controller, $method) = explode('@', $action);
        
        if (!class_exists($controller)) {
            Response::error("Controller {$controller} not found");
        }
        
        $instance = new $controller();
        
        if (!method_exists($instance, $method)) {
            Response::error("Method {$method} not found in {$controller}");
        }
        
        return call_user_func_array([$instance, $method], $params);
    }
}
