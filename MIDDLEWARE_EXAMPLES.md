# Middleware Usage Examples

This document provides practical examples of using the middleware system in various scenarios.

## Table of Contents
1. [Global Middleware](#global-middleware)
2. [Middleware Groups](#middleware-groups)
3. [Controller-Level Middleware](#controller-level-middleware)
4. [Creating Custom Middleware](#creating-custom-middleware)
5. [Complete Examples](#complete-examples)

---

## Global Middleware

Global middleware runs for every request in your application.

### Configuration (config/config.php)

```php
'middleware' => [
    'global' => [
        \App\Middleware\SecurityHeadersMiddleware::class,
        \App\Middleware\LoggingMiddleware::class,
    ],
    // ...
]
```

### When to Use
- Security headers (CORS, CSP, etc.)
- Request logging
- Performance monitoring
- Global request validation

---

## Middleware Groups

Middleware groups apply to specific areas of your application based on route prefixes.

### Configuration (config/config.php)

```php
'middleware' => [
    'groups' => [
        'admin' => [
            \App\Middleware\AuthMiddleware::class,
            \App\Middleware\AdminLogMiddleware::class,
        ],
        'frontend' => [
            \App\Middleware\CorsMiddleware::class,
        ],
        'api' => [
            \App\Middleware\RateLimitMiddleware::class,
        ],
    ],
]
```

### Route to Group Mapping

The Router automatically determines the middleware group based on the route:

- `/admin/*` → `admin` group
- `/api/*` → `api` group (if configured)
- All other routes → `frontend` group

### Example Routes

```
/admin/dashboard        → Uses: Global + Admin middleware
/admin/users/edit       → Uses: Global + Admin middleware
/blog/post              → Uses: Global + Frontend middleware
/api/data               → Uses: Global + API middleware
```

---

## Controller-Level Middleware

Controllers can register their own middleware that runs in addition to global and group middleware.

### Example 1: Simple Middleware Registration

```php
<?php
namespace App\Controller\Admin;

use App\Controller\AdminController;
use App\Middleware\CustomMiddleware;

class UsersController extends AdminController
{
    protected function registerMiddleware(): void
    {
        // Add middleware by class name
        $this->addMiddlewareByClass(\App\Middleware\AuditLogMiddleware::class);
        
        // Or add middleware instance
        $this->addMiddleware(new CustomMiddleware());
    }
    
    public function handle(): void
    {
        // Your controller logic
    }
}
```

### Example 2: Middleware with Parameters

```php
<?php
namespace App\Controller\Api;

use App\Core\Controller;
use App\Middleware\RateLimitMiddleware;

class DataController extends Controller
{
    protected function registerMiddleware(): void
    {
        // Rate limit: max 30 requests per minute
        $this->addMiddleware(new RateLimitMiddleware(30, 60));
    }
    
    public function handle(): void
    {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
    }
}
```

### Example 3: Multiple Middleware

```php
<?php
namespace App\Controller\Api;

use App\Core\Controller;
use App\Middleware\RateLimitMiddleware;
use App\Middleware\CorsMiddleware;

class PublicApiController extends Controller
{
    protected function registerMiddleware(): void
    {
        // Middleware is executed in the order added
        $this->addMiddleware(new CorsMiddleware());
        $this->addMiddleware(new RateLimitMiddleware(60, 60));
        $this->addMiddlewareByClass(\App\Middleware\LoggingMiddleware::class);
    }
    
    public function handle(): void
    {
        // API logic
    }
}
```

---

## Creating Custom Middleware

### Template

```php
<?php
namespace App\Middleware;

use App\Core\Middleware\MiddlewareInterface;
use App\Core\Middleware\RequestHandlerInterface;
use App\Core\Request;

class CustomMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): void
    {
        // Pre-processing logic
        // Example: Validate request, check permissions, modify request data
        
        // Continue to next middleware or final handler
        $handler->handle($request);
        
        // Post-processing logic (optional)
        // Example: Modify response, log completion time
    }
}
```

### Example: Permission Check Middleware

```php
<?php
namespace App\Middleware;

use App\Core\Middleware\MiddlewareInterface;
use App\Core\Middleware\RequestHandlerInterface;
use App\Core\Request;

class PermissionMiddleware implements MiddlewareInterface
{
    private string $requiredPermission;
    
    public function __construct(string $permission)
    {
        $this->requiredPermission = $permission;
    }
    
    public function process(Request $request, RequestHandlerInterface $handler): void
    {
        $userPermissions = $request->getSession('user_permissions', []);
        
        if (!in_array($this->requiredPermission, $userPermissions)) {
            http_response_code(403);
            echo "Access denied: Missing permission '{$this->requiredPermission}'";
            exit;
        }
        
        $handler->handle($request);
    }
}
```

### Using the Permission Middleware

```php
class AdminUsersController extends AdminController
{
    protected function registerMiddleware(): void
    {
        $this->addMiddleware(new \App\Middleware\PermissionMiddleware('manage_users'));
    }
}
```

---

## Complete Examples

### Example 1: Blog Controller with Caching

```php
<?php
namespace App\Controller;

use App\Core\Controller;

class BlogController extends Controller
{
    protected function registerMiddleware(): void
    {
        // Add caching middleware for better performance
        $this->addMiddlewareByClass(\App\Middleware\CacheMiddleware::class);
        $this->addMiddlewareByClass(\App\Middleware\LoggingMiddleware::class);
    }
    
    public function handle(): void
    {
        $posts = $this->getBlogPosts();
        $this->render('blog/index', ['posts' => $posts]);
    }
}
```

### Example 2: Admin Dashboard with Multiple Layers

**Configuration:**
```php
// config/config.php
'middleware' => [
    'global' => [
        \App\Middleware\SecurityHeadersMiddleware::class,
    ],
    'groups' => [
        'admin' => [
            \App\Middleware\AuthMiddleware::class,
            \App\Middleware\AdminLogMiddleware::class,
        ],
    ],
]
```

**Controller:**
```php
<?php
namespace App\Controller\Admin;

use App\Controller\AdminController;

class DashboardController extends AdminController
{
    protected function registerMiddleware(): void
    {
        // Additional middleware for dashboard
        $this->addMiddlewareByClass(\App\Middleware\AnalyticsMiddleware::class);
    }
    
    public function handle(): void
    {
        $this->render('admin/dashboard', [
            'stats' => $this->getStats(),
        ]);
    }
}
```

**Execution Flow:**
```
Request to /admin/dashboard
    ↓
1. SecurityHeadersMiddleware (global)
    ↓
2. AuthMiddleware (admin group)
    ↓
3. AdminLogMiddleware (admin group)
    ↓
4. AnalyticsMiddleware (controller)
    ↓
5. DashboardController::handle()
```

### Example 3: API with Rate Limiting and CORS

```php
<?php
namespace App\Controller\Api;

use App\Core\Controller;
use App\Middleware\RateLimitMiddleware;
use App\Middleware\CorsMiddleware;

class UsersController extends Controller
{
    protected function registerMiddleware(): void
    {
        $this->addMiddleware(new CorsMiddleware());
        $this->addMiddleware(new RateLimitMiddleware(100, 60)); // 100 req/min
    }
    
    public function handle(): void
    {
        header('Content-Type: application/json');
        
        $users = $this->getUsers();
        echo json_encode([
            'status' => 'success',
            'data' => $users,
        ]);
    }
}
```

---

## Best Practices

1. **Order matters**: Middleware is executed in the order it's registered
   - Global → Group → Controller
   - Within each level, in registration order

2. **Keep middleware focused**: Each middleware should do one thing well

3. **Use groups for common patterns**: 
   - `admin` group for authenticated admin routes
   - `api` group for API-specific concerns
   - `frontend` group for public-facing routes

4. **Controller middleware for specific needs**: 
   - Use when only certain controllers need specific behavior
   - Example: Rate limiting on API endpoints only

5. **Always call next handler**: Unless you want to terminate the request
   - `$handler->handle($request);`

6. **Handle errors gracefully**: Don't let middleware crash the application

---

## Troubleshooting

### Middleware not executing
- Check that middleware is properly registered in config or controller
- Verify middleware class implements `MiddlewareInterface`
- Check class name spelling and namespace

### Infinite redirect loops
- Ensure AuthMiddleware doesn't run on login page
- Use route-based group assignment carefully

### Headers already sent
- Middleware setting headers should run early
- Don't output content before headers
- Use output buffering if necessary (already enabled in App::run())

### Performance issues
- Minimize work in middleware
- Use caching for expensive operations
- Consider async processing for non-critical tasks
