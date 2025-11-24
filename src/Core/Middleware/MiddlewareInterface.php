<?php
namespace App\Core\Middleware;

use App\Core\Request;

/**
 * PSR-15-inspired Middleware Interface
 * 
 * Middleware components process HTTP requests in a stack-based manner.
 */
interface MiddlewareInterface
{
    /**
     * Process an incoming request.
     *
     * Processes an incoming request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     *
     * @param Request $request The incoming request
     * @param RequestHandlerInterface $handler The request handler
     * @return void
     */
    public function process(Request $request, RequestHandlerInterface $handler): void;
}
