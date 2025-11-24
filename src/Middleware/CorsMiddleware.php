<?php
namespace App\Middleware;

use App\Core\Middleware\MiddlewareInterface;
use App\Core\Middleware\RequestHandlerInterface;
use App\Core\Request;

/**
 * CORS Middleware
 * 
 * Handles Cross-Origin Resource Sharing (CORS) headers.
 * 
 * Note: This example uses '*' for Access-Control-Allow-Origin.
 * In production, configure specific allowed origins for security.
 */
class CorsMiddleware implements MiddlewareInterface
{
    private array $allowedOrigins;
    
    /**
     * Constructor
     * 
     * @param array $allowedOrigins List of allowed origins. Use ['*'] to allow all (not recommended for production)
     */
    public function __construct(array $allowedOrigins = ['*'])
    {
        $this->allowedOrigins = $allowedOrigins;
    }

    /**
     * Process the request.
     *
     * @param Request $request
     * @param RequestHandlerInterface $handler
     * @return void
     */
    public function process(Request $request, RequestHandlerInterface $handler): void
    {
        $origin = $request->getServer('HTTP_ORIGIN');
        
        // Set CORS headers
        if (in_array('*', $this->allowedOrigins)) {
            header('Access-Control-Allow-Origin: *');
        } elseif ($origin && in_array($origin, $this->allowedOrigins)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Vary: Origin');
        }
        
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
