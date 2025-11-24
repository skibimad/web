# Quick Start Guide - Middleware System

This guide provides a quick reference for using the new middleware system.

## 📚 Documentation Index

1. **[MIDDLEWARE.md](MIDDLEWARE.md)** - Complete system documentation
2. **[MIDDLEWARE_EXAMPLES.md](MIDDLEWARE_EXAMPLES.md)** - Practical usage examples
3. **[ARCHITECTURE.md](ARCHITECTURE.md)** - Visual diagrams and architecture
4. **[IMPLEMENTATION_SUMMARY.md](IMPLEMENTATION_SUMMARY.md)** - Overview and migration guide

## 🚀 Quick Start

### 1. Add Global Middleware (All Requests)

Edit `config/config.php`:

```php
'middleware' => [
    'global' => [
        \App\Middleware\SecurityHeadersMiddleware::class,
        \App\Middleware\LoggingMiddleware::class,
    ],
]
```

### 2. Configure Middleware Groups (Route-Based)

Edit `config/config.php`:

```php
'middleware' => [
    'groups' => [
        'admin' => [
            \App\Middleware\AuthMiddleware::class,  // Already configured!
        ],
        'frontend' => [
            \App\Middleware\CorsMiddleware::class,
        ],
    ],
]
```

- Routes starting with `/admin` → `admin` group
- All other routes → `frontend` group

### 3. Add Controller-Level Middleware

In your controller:

```php
<?php
namespace App\Controller\Api;

use App\Core\Controller;
use App\Middleware\RateLimitMiddleware;

class MyController extends Controller
{
    protected function registerMiddleware(): void
    {
        // Add by instance (with parameters)
        $this->addMiddleware(new RateLimitMiddleware(60, 60));
        
        // Or add by class name
        $this->addMiddlewareByClass(\App\Middleware\LoggingMiddleware::class);
    }
    
    public function handle(): void
    {
        // Your controller logic here
    }
}
```

## 📦 Available Middleware

### AuthMiddleware
**Purpose:** Ensure user is authenticated  
**Use Case:** Admin area, protected routes  
**Example:**
```php
'admin' => [
    \App\Middleware\AuthMiddleware::class,
]
```

### LoggingMiddleware
**Purpose:** Log request information  
**Use Case:** Debugging, monitoring  
**Example:**
```php
'global' => [
    \App\Middleware\LoggingMiddleware::class,
]
```

### CorsMiddleware
**Purpose:** Handle CORS headers  
**Use Case:** API endpoints, cross-origin requests  
**Example:**
```php
// Allow all origins (not recommended for production)
new CorsMiddleware(['*'])

// Allow specific origins (recommended)
new CorsMiddleware(['https://example.com', 'https://app.example.com'])
```

### SecurityHeadersMiddleware
**Purpose:** Add security headers  
**Use Case:** All requests  
**Example:**
```php
'global' => [
    \App\Middleware\SecurityHeadersMiddleware::class,
]
```

### RateLimitMiddleware
**Purpose:** Limit request rate  
**Use Case:** API endpoints, preventing abuse  
**Example:**
```php
// 60 requests per 60 seconds
new RateLimitMiddleware(60, 60)

// 100 requests per minute
new RateLimitMiddleware(100, 60)
```

## 🔧 Creating Custom Middleware

```php
<?php
namespace App\Middleware;

use App\Core\Middleware\MiddlewareInterface;
use App\Core\Middleware\RequestHandlerInterface;
use App\Core\Request;

class MyCustomMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): void
    {
        // Do something before the request
        
        // Continue to next middleware or controller
        $handler->handle($request);
        
        // Do something after the request (optional)
    }
}
```

## 🎯 Common Use Cases

### Protect Admin Area
Already configured! Admin routes automatically use AuthMiddleware.

### Add Rate Limiting to API
```php
class ApiController extends Controller
{
    protected function registerMiddleware(): void
    {
        $this->addMiddleware(new RateLimitMiddleware(100, 60));
    }
}
```

### Enable CORS for Frontend
```php
// In config/config.php
'groups' => [
    'frontend' => [
        \App\Middleware\CorsMiddleware::class,
    ],
]
```

### Log All Admin Actions
```php
// In config/config.php
'groups' => [
    'admin' => [
        \App\Middleware\AuthMiddleware::class,
        \App\Middleware\LoggingMiddleware::class,  // Add this
    ],
]
```

## 🔍 Execution Order

Middleware executes in this order:

```
1. Global Middleware (from config.php)
   ↓
2. Group Middleware (based on route)
   ↓
3. Controller Middleware (from registerMiddleware)
   ↓
4. Controller Action (handle method)
```

Example for `/admin/dashboard`:
```
SecurityHeaders → Logging → Auth → [Controller Middleware] → Dashboard::handle()
```

## ⚠️ Important Notes

1. **Order Matters** - Middleware executes in registration order
2. **Always Call Next** - Unless you want to terminate the request:
   ```php
   $handler->handle($request);  // Don't forget this!
   ```
3. **Group Auto-Detection** - Routes are automatically assigned to groups:
   - `/admin/*` → admin group
   - Others → frontend group

## 🐛 Troubleshooting

**Middleware not running?**
- Check class name and namespace
- Verify middleware implements `MiddlewareInterface`
- Check if it's properly registered in config or controller

**Headers already sent?**
- Middleware that sets headers should run early
- Output buffering is already enabled in `App::run()`

**Infinite redirects?**
- Make sure AuthMiddleware doesn't run on login page
- Check middleware group assignment

## 📖 Learn More

- See [MIDDLEWARE_EXAMPLES.md](MIDDLEWARE_EXAMPLES.md) for complete examples
- See [ARCHITECTURE.md](ARCHITECTURE.md) for visual diagrams
- See [MIDDLEWARE.md](MIDDLEWARE.md) for detailed documentation

## ✅ Next Steps

1. Review existing middleware in `src/Middleware/`
2. Configure global middleware in `config/config.php` as needed
3. Create custom middleware for your specific needs
4. Test your middleware setup

Happy coding! 🎉
