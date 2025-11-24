<?php
namespace App\Middleware;

use App\Core\Middleware\MiddlewareInterface;
use App\Core\Middleware\RequestHandlerInterface;
use App\Core\Request;

/**
 * Authentication Middleware
 * 
 * Ensures that the user is authenticated before processing the request.
 * Excludes login and logout routes from authentication check.
 */
class AuthMiddleware implements MiddlewareInterface
{
    /**
     * Routes that should be excluded from authentication check
     */
    private const EXCLUDED_ROUTES = [
        'admin/login',
        'admin/logout',
    ];

    /**
     * Process the request.
     *
     * @param Request $request
     * @param RequestHandlerInterface $handler
     * @return void
     */
    public function process(Request $request, RequestHandlerInterface $handler): void
    {
        // Get current route
        $route = $request->getQuery('q', '');
        
        // Skip authentication for excluded routes
        if ($this->isExcludedRoute($route)) {
            $handler->handle($request);
            return;
        }
        
        // Check if user is authenticated
        $adminUserId = $request->getSession('admin_user_id');

        if ($adminUserId === null) {
            // Store the intended URL for redirect after login
            $request->setSession('intended_url', $_SERVER['REQUEST_URI'] ?? '/?q=admin/index');
            
            // Redirect to admin login page (using query string format for compatibility)
            header('Location: /?q=admin/login');
            exit;
        }

        // User is authenticated, continue to next middleware or handler
        $handler->handle($request);
    }

    /**
     * Check if the route should be excluded from authentication
     *
     * @param string $route
     * @return bool
     */
    private function isExcludedRoute(string $route): bool
    {
        $route = strtolower(trim($route, '/'));
        
        foreach (self::EXCLUDED_ROUTES as $excludedRoute) {
            if ($route === $excludedRoute || strpos($route, $excludedRoute) === 0) {
                return true;
            }
        }
        
        return false;
    }
}
