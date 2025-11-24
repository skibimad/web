<?php
namespace App\Controller;

use App\Core\Contract\ViewInterface;
use App\Core\Controller;
use App\View\Admin\View;

abstract class AdminController extends Controller
{
    /**
     * AccountController constructor.
     * Ensures that only admin users can access this controller.
     */
    public function __construct()
    {
        parent::__construct();
        // Note: Authentication is now handled by AuthMiddleware
        // which is automatically applied via the 'admin' middleware group in config.php
        // or can be explicitly added in registerMiddleware() method
    }

    /**
     * Register middleware for admin controllers.
     * This method demonstrates how to add middleware at the controller level.
     * Note: The 'admin' middleware group in config.php already applies AuthMiddleware,
     * so this is optional and serves as an example.
     *
     * @return void
     */
    protected function registerMiddleware(): void
    {
        // Middleware can be added here if needed for specific admin controllers
        // Example: $this->addMiddlewareByClass(\App\Middleware\AdminLogMiddleware::class);
    }

    protected function getView(string $template, array $params = []): ViewInterface
    {
        return new View($this, $template, $params);
    }

}