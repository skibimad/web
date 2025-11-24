<?php
namespace App\Middleware;

use App\Core\Middleware\MiddlewareInterface;
use App\Core\Middleware\RequestHandlerInterface;
use App\Core\Request;

/**
 * CORS Middleware
 * 
 * Handles Cross-Origin Resource Sharing (CORS) headers.
 */
class CorsMiddleware implements MiddlewareInterface
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
        // Set CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        // Handle preflight requests
        if ($request->getRequestMethod() === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
        
        // Continue to next middleware or handler
        $handler->handle($request);
    }
}
