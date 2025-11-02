<?php

namespace App\Core;

class Router
{
    private $routes = [];
    private $middlewares = [];
    
    public function get(string $path, $handler, array $middlewares = []): void
    {
        $this->addRoute('GET', $path, $handler, $middlewares);
    }
    
    public function post(string $path, $handler, array $middlewares = []): void
    {
        $this->addRoute('POST', $path, $handler, $middlewares);
    }
    
    private function addRoute(string $method, string $path, $handler, array $middlewares): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'middlewares' => $middlewares
        ];
    }
    
    public function dispatch(Request $request, Response $response)
    {
        $uri = $request->getUri();
        $method = $request->getMethod();
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            
            $pattern = $this->convertToPattern($route['path']);
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match
                
                // Execute middlewares
                foreach ($route['middlewares'] as $middleware) {
                    $middlewareInstance = new $middleware();
                    if (!$middlewareInstance->handle($request, $response)) {
                        return;
                    }
                }
                
                return $this->executeHandler($route['handler'], $matches, $request, $response);
            }
        }
        
        // 404 Not Found
        $response->setStatusCode(404);
        $this->render('errors/404', [], $response);
    }
    
    private function convertToPattern(string $path): string
    {
        // Convert {param} to regex capture groups
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
    
    private function executeHandler($handler, array $params, Request $request, Response $response)
    {
        if (is_callable($handler)) {
            return call_user_func_array($handler, array_merge([$request, $response], $params));
        }
        
        if (is_string($handler) && strpos($handler, '@') !== false) {
            [$controller, $method] = explode('@', $handler);
            $controllerClass = "App\\Controllers\\{$controller}";
            
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                
                if (method_exists($controllerInstance, $method)) {
                    return call_user_func_array(
                        [$controllerInstance, $method],
                        array_merge([$request, $response], $params)
                    );
                }
            }
        }
        
        throw new \Exception("Handler not found");
    }
    
    private function render(string $view, array $data = [], Response $response = null): void
    {
        $viewPath = __DIR__ . "/../Views/{$view}.phtml";
        
        if (file_exists($viewPath)) {
            extract($data);
            ob_start();
            require $viewPath;
            $content = ob_get_clean();
            
            if ($response) {
                $response->setContent($content)->send();
            } else {
                echo $content;
            }
        } else {
            echo "View not found: {$view}";
        }
    }
}
