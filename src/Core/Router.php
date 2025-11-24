<?php
namespace App\Core;

use App\Controller\ErrorController;
use App\Controller\NotFoundController;
use App\Core\Error\ErrorHandler;
use App\Core\Middleware\RequestHandlerInterface;
use App\Core\Config;

/**
 @todo: refactor
 */
class Router implements RequestHandlerInterface
{
    /**
     * Handle the request.
     * This method is called by the middleware pipeline.
     *
     * @param Request $request
     * @return void
     */
    public function handle(Request $request): void
    {
        $this->dispatch();
    }

    public function dispatch(): void
    {
        
            $route = $_GET['q'] ?? '';
            

            // Handle route as separate Controller for Action
            // This allows for cleaner routing and better separation of concerns
            if (!$this->dispatchV2($route)) {
                ErrorHandler::handle404();
            }
            return;

            // Fallback to controllers with multiple segments
            $parts = explode('/', $route);
            if (count($parts) === 1) {
                $parts[] = 'index';
            }
            
            $action = array_pop($parts) ?: 'index';
            $controllerName = implode('\\', array_map('ucfirst', $parts)) ?: 'Home';

            $class = 'App\\Controller\\' . ucfirst($controllerName) . 'Controller';
            if (!class_exists($class)) {
                ErrorHandler::handle404();
                //throw new \RuntimeException("Controller not found: $class");
            }

            $controller = new $class();
            if (!method_exists($controller, $action) || !is_callable([$controller, $action])) {
                ErrorHandler::handle404();
                //throw new \RuntimeException("Action not found: $action in $class");
            }
                
            $controller->$action();
    }

    /**
     * Dispatch a route to the appropriate controller/action.
     * e.g. 'account/profile' -> \App\Controller\Account\ProfileController
     */
    private function dispatchV2(string $route): bool
    {
        $parts = array_filter(explode('/', $route));
        if (count($parts) < 2) {
            $parts[] = 'index'; // Default action if not specified
        }
        
        // Determine middleware group based on route
        $middlewareGroup = $this->getMiddlewareGroupForRoute($parts);
        
        // Convert kebab-case to camelCase for each part
        $parts = array_map(function($part) {
            return preg_replace_callback('/-([a-z])/', function($matches) {
                return strtoupper($matches[1]);
            }, $part);
        }, $parts);
        
        $route = implode('\\', array_map('ucfirst', $parts));
        $route = str_replace('_', '', $route); // Remove underscores for class names

        $controllerClass = '\\App\\Controller\\' . $route;

        if (!class_exists($controllerClass) || !is_subclass_of($controllerClass, Controller::class)) {
            $controllerClass .= 'Controller';
            if (!class_exists($controllerClass) || !is_subclass_of($controllerClass, Controller::class)) {
                return false;
            }
        }

        $controller = new $controllerClass();
        
        // Apply middleware group to controller if applicable
        if ($middlewareGroup !== null) {
            $this->applyMiddlewareGroup($controller, $middlewareGroup);
        }
        
        // Execute controller with its middleware
        $controller->executeWithMiddleware(function() use ($controller) {
            $controller->handle();
        });

        return true;
    }

    /**
     * Determine the middleware group based on the route.
     *
     * @param array $parts Route parts
     * @return string|null
     */
    private function getMiddlewareGroupForRoute(array $parts): ?string
    {
        // Check if route starts with 'admin'
        if (isset($parts[0]) && strtolower($parts[0]) === 'admin') {
            return 'admin';
        }
        
        // Default to frontend group
        return 'frontend';
    }

    /**
     * Apply middleware group to a controller.
     *
     * @param Controller $controller
     * @param string $group
     * @return void
     */
    private function applyMiddlewareGroup(Controller $controller, string $group): void
    {
        $config = Config::getInstance();
        $middlewareClasses = $config->get("middleware.groups.{$group}", []);
        
        foreach ($middlewareClasses as $middlewareClass) {
            if (class_exists($middlewareClass)) {
                $controller->addMiddleware(new $middlewareClass());
            }
        }
    }

}
