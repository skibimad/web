# Middleware System Documentation

This custom framework now supports PSR-15 inspired middleware functionality, allowing you to process HTTP requests through a pipeline of reusable components.

## Overview

The middleware system provides:
- **Global middleware** - Applied to all requests
- **Middleware groups** - Applied to specific areas (e.g., admin, frontend)
- **Controller-level middleware** - Applied to individual controllers

## Architecture

### Core Components

1. **MiddlewareInterface** - Interface for all middleware classes
2. **RequestHandlerInterface** - Interface for request handlers
3. **MiddlewarePipeline** - Processes requests through a stack of middleware
4. **App** - Manages global middleware and the application pipeline
5. **Router** - Acts as a request handler and applies middleware groups
6. **Controller** - Supports per-controller middleware registration

## Usage

### 1. Global Middleware Configuration

Global middleware is configured in `config/config.php` and runs for every request:

```php
'middleware' => [
    'global' => [
        \App\Middleware\SecurityHeadersMiddleware::class,
        \App\Middleware\LoggingMiddleware::class,
    ],
    // ...
]
```

### 2. Middleware Groups

Middleware groups are applied based on the route prefix. For example, all routes starting with `/admin` use the `admin` group:

```php
'middleware' => [
    'groups' => [
        'admin' => [
            \App\Middleware\AuthMiddleware::class,
        ],
        'frontend' => [
            \App\Middleware\CorsMiddleware::class,
        ],
    ],
]
```

### 3. Controller-Level Middleware

Controllers can register their own middleware by overriding the `registerMiddleware()` method:

```php
class MyController extends Controller
{
    protected function registerMiddleware(): void
    {
        // Add middleware by class name
        $this->addMiddlewareByClass(\App\Middleware\CustomMiddleware::class);
        
        // Or add an instance
        $this->addMiddleware(new \App\Middleware\AnotherMiddleware());
    }
}
```

## Creating Custom Middleware

To create a custom middleware, implement the `MiddlewareInterface`:

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
        // Pre-processing logic here
        // For example: validate request, check permissions, etc.
        
        // Continue to next middleware or final handler
        $handler->handle($request);
        
        // Post-processing logic here (if needed)
        // For example: modify response, log completion, etc.
    }
}
```

## Execution Flow

1. **Global Middleware** (from config.php `middleware.global`)
2. **Middleware Group** (based on route: admin, frontend, etc.)
3. **Controller Middleware** (registered in controller)
4. **Controller Action** (the actual controller method)

## Examples

### Example 1: Admin Area with Authentication

All admin routes automatically use the `AuthMiddleware`:

```
Route: /admin/dashboard
Flow: Global Middleware → Admin Group (AuthMiddleware) → Controller Middleware → Dashboard Controller
```

### Example 2: Frontend with CORS

Frontend routes use the CORS middleware:

```
Route: /api/data
Flow: Global Middleware → Frontend Group (CorsMiddleware) → Controller Middleware → API Controller
```

### Example 3: Custom Controller Middleware

```php
class BlogController extends Controller
{
    protected function registerMiddleware(): void
    {
        $this->addMiddlewareByClass(\App\Middleware\CacheMiddleware::class);
    }
}
```

## Built-in Middleware

### AuthMiddleware
Ensures user is authenticated before accessing protected resources. Redirects to login if not authenticated.

### LoggingMiddleware
Logs request information for debugging and monitoring purposes.

### CorsMiddleware
Handles CORS headers for cross-origin requests.

### SecurityHeadersMiddleware
Adds security-related HTTP headers to responses.

## Best Practices

1. **Keep middleware focused** - Each middleware should have a single responsibility
2. **Order matters** - Middleware is executed in the order it's registered
3. **Use groups wisely** - Separate concerns (admin vs frontend) using middleware groups
4. **Avoid heavy processing** - Middleware should be lightweight and fast
5. **Always call next handler** - Unless you want to terminate the request early

## Migration Guide

### Before (Old checkAuth in Controller)
```php
protected function checkAuth(): void
{
    if (!$uid) {
        $this->redirect('/auth/login');
    }
}
```

### After (Using AuthMiddleware)
The authentication is now handled automatically by `AuthMiddleware` in the admin middleware group. No need to check auth in individual controllers.
