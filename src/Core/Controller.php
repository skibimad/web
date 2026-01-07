<?php
namespace App\Core;

use App\Core\Contract\ControllerInterface;
use App\Core\Contract\ResponseInterface;
use App\Core\Contract\ViewInterface;
use App\Core\Middleware\MiddlewareInterface;
use App\Core\Middleware\MiddlewarePipeline;
use App\Core\Middleware\RequestHandlerInterface;

abstract class Controller implements ControllerInterface
{
    private Request $request;

    private ResponseInterface $response;
    //private ResponseInterface $response;

    /**
     * @var MiddlewareInterface[]
     */
    protected array $middleware = [];

    public function __construct()
    {
        $this->request = Request::getInstance();
        
        // Register middleware first, allowing middleware-based auth to be set up
        $this->registerMiddleware();
    }

    /**
     * Register middleware for this controller.
     * Override this method in child controllers to add middleware.
     *
     * @return void
     */
    protected function registerMiddleware(): void
    {
        // Override in child controllers to register middleware
    }

    /**
     * Add middleware to this controller.
     *
     * @param MiddlewareInterface $middleware
     * @return self
     */
    public function addMiddleware(MiddlewareInterface $middleware): self
    {
        $this->middleware[] = $middleware;
        return $this;
    }

    /**
     * Add middleware by class name.
     *
     * @param string $middlewareClass
     * @return self
     */
    protected function addMiddlewareByClass(string $middlewareClass): self
    {
        if (class_exists($middlewareClass)) {
            $this->middleware[] = new $middlewareClass();
        }
        return $this;
    }

    /**
     * Get the middleware registered for this controller.
     *
     * @return MiddlewareInterface[]
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    /**
     * Execute the controller with its middleware.
     * This method should be called instead of the action method directly.
     *
     * @param callable $action The action to execute after middleware
     * @return void
     */
    public function executeWithMiddleware(callable $action): void
    {
        if (empty($this->middleware)) {
            // No middleware, execute action directly
            $action();
            return;
        }

        // Create a pipeline for controller middleware
        $pipeline = new MiddlewarePipeline();
        
        foreach ($this->middleware as $middleware) {
            $pipeline->pipe($middleware);
        }

        // Set the action as the fallback handler
        $handler = new class($action) implements RequestHandlerInterface {
            private $action;

            public function __construct(callable $action)
            {
                $this->action = $action;
            }

            public function handle(Request $request): void
            {
                ($this->action)();
            }
        };

        $pipeline->setFallbackHandler($handler);
        $pipeline->handle($this->request);
    }


    /**
     * @deprecated
     * Alias for request method to get a value from the request.
     */
    public function getRequest(?string $key = null): mixed
    {
        return $key ? $this->request($key) : $this->request();
    }

    public function request(?string $key = null): mixed
    {
        if ($key === null) {
            //main request object
            return $this->request;
        }

        return $this->request->request($key);
    }

    protected function response(): ResponseInterface
    {
        if (!isset($this->response)) {
            $this->response = new Response();
        }
        return $this->response;
    }

    

    protected function getView(string $template, array $params = []): ViewInterface
    {
        return new View($this->request(), $template, $params);
    }

    protected function render(string $view, array $params = [], bool $standalone = false): string
    { 
        $viewObj = $this->getView($view, $params);
        echo $viewObj->render($params, $standalone);
        return '';
    }


    public function forward(string $controller, string $action = 'index', array $params = []): void
    {
        if ($this->forvardV2($controller, $action, $params)) {
            return;
        }

        $controllerClass = 'App\\Controller\\' . ucfirst($controller) . 'Controller';
        if (!class_exists($controllerClass)) {
            throw new \RuntimeException("Controller not found: $controllerClass");
        }

        $controllerInstance = new $controllerClass();
        if (!method_exists($controllerInstance, $action)) {
            throw new \RuntimeException("Action not found: $action in $controllerClass");
        }

        call_user_func_array([$controllerInstance, $action], $params);
    }

    /**
     * Forward to another controller and action (version 2)
     *
     * This method is an alternative implementation of the forward method.
     * It allows for more flexibility in forwarding requests to different controllers and actions.
     *
     * @param string $controller The name of the controller to forward to
     * @param string $action The action method to call in the controller
     * @param array $params Additional parameters to pass to the action method
     * @return bool Returns true if the forwarding was successful, false otherwise
     */
    protected function forvardV2(string $controller, string $action = 'index', array $params = []): bool
    {

        $controllerClass = 'App\\Controller\\' . ucfirst($controller) . '\\'. ucfirst($action) ;
        if (!class_exists($controllerClass)) {
            return false;
        }

        $controllerInstance = new $controllerClass();
        if (!method_exists($controllerInstance, 'handle')) {
            return false;
        }

        call_user_func_array([$controllerInstance, 'handle'], $params);

        return true;
    }

    /**
     * Redirect to a given URL
     *
     * @param string $url The URL to redirect to
     * @param array $args Query parameters to append
     */
    public function redirect(string $url, array $args = []): void
    {
        if (!empty($args)) {
            $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($args);
        }

        // Prevent header injection by removing newlines
        $url = preg_replace('/[\r\n]/', '', $url);

        if (!filter_var($url, FILTER_VALIDATE_URL) && strpos($url, '/') !== 0) {
            throw new \InvalidArgumentException("Invalid redirect URL: $url");
        }

        header("Location: $url");
        exit;
    }

    /**
     * Redirect to the referer URL
     * 
     * This method will redirect the user back to the page they came from.
     * If no referer is available, it will redirect to the home page.
     */
    public function redirectReferer(): void
    {
        $referer = $this->request('HTTP_REFERER') ?? '/';
        $this->redirect($referer);
    }

}
