<?php
namespace App\Core\Middleware;

use App\Core\Request;

/**
 * PSR-15-inspired Request Handler Interface
 * 
 * Handles a server request and produces a response.
 */
interface RequestHandlerInterface
{
    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     *
     * @param Request $request The incoming request
     * @return void
     */
    public function handle(Request $request): void;
}
