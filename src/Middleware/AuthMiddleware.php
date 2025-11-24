<?php
namespace App\Middleware;

use App\Core\Middleware\MiddlewareInterface;
use App\Core\Middleware\RequestHandlerInterface;
use App\Core\Request;

/**
 * Authentication Middleware
 * 
 * Ensures that the user is authenticated before processing the request.
 */
class AuthMiddleware implements MiddlewareInterface
{
    /**
     * Process the request.
     *
     * @param Request $request
     * @param RequestHandlerInterface $handler
     * @return void
     */
    public function process(Request $request, RequestHandlerInterface $handler): void
    {
        // Check if user is authenticated
        $uid = $request->getSession('uid');

        if ($uid === null) {
            // Redirect to login page if not authenticated
            header('Location: /?q=auth/login');
            exit;
        }

        // User is authenticated, continue to next middleware or handler
        $handler->handle($request);
    }
}
