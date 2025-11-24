<?php
namespace App\Core;

use App\Core\Router;
use App\Core\Middleware\MiddlewarePipeline;
use App\Core\Middleware\MiddlewareInterface;

class App
{
    private static ?App $instance = null;

    private Request $request;

    private Router $router;

    private MiddlewarePipeline $pipeline;

    private function __construct()
    {
        $this->request = Request::getInstance();
        $this->router = new Router();
        $this->pipeline = new MiddlewarePipeline();
        
        // Load global middleware from config
        $this->loadGlobalMiddleware();
    }

    public static function getInstance(): App
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function run(): void
    {
        ob_start();
        try{
         $this->handleRequest();
        } catch (\Throwable $e) {
            ob_end_clean();
            throw new \Exception($e);
        }
        ob_end_flush();
    }


    private function handleRequest(): void
    {
        // Set the router as the fallback handler for the pipeline
        $this->pipeline->setFallbackHandler($this->getRouter());
        
        // Process the request through the middleware pipeline
        $this->pipeline->handle($this->request);
    }

    protected function getRouter(): Router
    {
        return $this->router;
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Get the middleware pipeline.
     *
     * @return MiddlewarePipeline
     */
    public function getPipeline(): MiddlewarePipeline
    {
        return $this->pipeline;
    }

    /**
     * Load global middleware from configuration.
     *
     * @return void
     */
    private function loadGlobalMiddleware(): void
    {
        $middleware = Config::get('middleware.global', []);

        foreach ($middleware as $middlewareClass) {
            if (class_exists($middlewareClass)) {
                $this->pipeline->pipe(new $middlewareClass());
            }
        }
    }

    /**
     * Add middleware to the application pipeline.
     *
     * @param MiddlewareInterface $middleware
     * @return self
     */
    public function addMiddleware(MiddlewareInterface $middleware): self
    {
        $this->pipeline->pipe($middleware);
        return $this;
    }
}