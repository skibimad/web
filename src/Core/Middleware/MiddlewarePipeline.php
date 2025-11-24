<?php
namespace App\Core\Middleware;

use App\Core\Request;

/**
 * Middleware Pipeline
 * 
 * Processes a request through a stack of middleware components.
 */
class MiddlewarePipeline implements RequestHandlerInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    private array $middleware = [];

    /**
     * @var RequestHandlerInterface|null
     */
    private ?RequestHandlerInterface $fallbackHandler = null;

    /**
     * Add middleware to the pipeline.
     *
     * @param MiddlewareInterface $middleware
     * @return self
     */
    public function pipe(MiddlewareInterface $middleware): self
    {
        $this->middleware[] = $middleware;
        return $this;
    }

    /**
     * Set the fallback handler.
     *
     * @param RequestHandlerInterface $handler
     * @return self
     */
    public function setFallbackHandler(RequestHandlerInterface $handler): self
    {
        $this->fallbackHandler = $handler;
        return $this;
    }

    /**
     * Handle the request by processing through the middleware stack.
     *
     * @param Request $request
     * @return void
     */
    public function handle(Request $request): void
    {
        $this->processMiddleware($request, 0);
    }

    /**
     * Process middleware at the given index.
     *
     * @param Request $request
     * @param int $index
     * @return void
     */
    private function processMiddleware(Request $request, int $index): void
    {
        // If no more middleware, call the fallback handler
        if (!isset($this->middleware[$index])) {
            if ($this->fallbackHandler !== null) {
                $this->fallbackHandler->handle($request);
            }
            return;
        }

        // Create a handler for the next middleware in the stack
        $next = new class($this, $request, $index + 1) implements RequestHandlerInterface {
            private MiddlewarePipeline $pipeline;
            private Request $request;
            private int $nextIndex;

            public function __construct(MiddlewarePipeline $pipeline, Request $request, int $nextIndex)
            {
                $this->pipeline = $pipeline;
                $this->request = $request;
                $this->nextIndex = $nextIndex;
            }

            public function handle(Request $request): void
            {
                $this->pipeline->processMiddleware($request, $this->nextIndex);
            }
        };

        // Process current middleware
        $this->middleware[$index]->process($request, $next);
    }
}
