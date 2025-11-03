<?php

namespace App\Core;

/**
 * Router - Dynamic routing based on URL structure
 */
class Router
{
    private $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    /**
     * Dispatch request to appropriate controller
     */
    public function dispatch(): void
    {
        $uri = $this->request->getUri();
        
        // Parse URI to determine controller
        $controller = $this->resolveController($uri);
        
        if (!class_exists($controller)) {
            $this->notFound();
            return;
        }
        
        // Instantiate controller and call handle method
        $controllerInstance = new $controller();
        
        if (!method_exists($controllerInstance, 'handle')) {
            $this->notFound();
            return;
        }
        
        $controllerInstance->handle($this->request);
    }
    
    /**
     * Resolve controller class from URI
     * Examples:
     *   / -> App\Controllers\HomeController
     *   /blog -> App\Controllers\BlogController
     *   /admin -> App\Admin\AdminController
     *   /admin/blog/edit -> App\Admin\Blog\EditController
     *   /foo/bar/baz/acme -> App\Foo\Bar\Baz\AcmeController
     */
    private function resolveController(string $uri): string
    {
        // Handle root
        if ($uri === '/') {
            return 'App\\Controllers\\HomeController';
        }
        
        // Remove leading slash and split into parts
        $parts = explode('/', trim($uri, '/'));
        
        // Special case: /admin maps to App\Admin\AdminController
        if (count($parts) === 1 && $parts[0] === 'admin') {
            return 'App\\Admin\\AdminController';
        }
        
        // Last part becomes the controller name, others become namespace
        $controllerName = ucfirst(array_pop($parts)) . 'Controller';
        
        // Build namespace from remaining parts
        if (empty($parts)) {
            $namespace = 'App\\Controllers';
        } else {
            $namespaceParts = array_map('ucfirst', $parts);
            $namespace = 'App\\' . implode('\\', $namespaceParts);
        }
        
        return $namespace . '\\' . $controllerName;
    }
    
    /**
     * Handle 404 Not Found
     */
    private function notFound(): void
    {
        ErrorHandler::handle404();
    }
}
